// resources/js/utils/fsrs.js

const w = [
    0.4, 0.6, 1.4, 2.4, 4.93, 0.94, 0.86, 0.01,
    1.49, 0.14, 0.94, 2.18, 0.05, 0.34, 1.26, 0.29, 2.61
];
const requestRetention = 0.9;
const maximumInterval = 36500;

const STATE_NEW = 0;
const STATE_LEARNING = 1;
const STATE_REVIEW = 2;
const STATE_RELEARNING = 3;

const RATING_AGAIN = 1;
const RATING_HARD = 2;
const RATING_GOOD = 3;
const RATING_EASY = 4;

function initStability(rating) {
    return Math.max(0.1, w[rating - 1]);
}

function initDifficulty(rating) {
    return Math.min(Math.max(w[4] - w[5] * (rating - 3), 1), 10);
}

function meanReversion(init, current) {
    return w[7] * init + (1 - w[7]) * current;
}

function nextDifficulty(d, rating) {
    const nextD = d - w[6] * (rating - 3);
    return Math.min(Math.max(meanReversion(w[4], nextD), 1), 10);
}

function shortTermStability(s, rating) {
    return s * Math.exp(w[16] * (rating - 3 + 0.1));
}

function nextRecallStability(d, s, r, rating) {
    const hardPenalty = rating === RATING_HARD ? w[15] : 1;
    const easyBonus = rating === RATING_EASY ? w[16] : 1;
    return s * (1 + Math.exp(w[8]) * 
        (11 - d) * 
        Math.pow(s, -w[9]) * 
        (Math.exp((1 - requestRetention) * w[10]) - 1) *
        hardPenalty * easyBonus);
}

function nextForgetStability(d, s, r) {
    return w[11] * 
        Math.pow(d, -w[12]) * 
        (Math.pow(s + 1, w[13]) - 1) * 
        Math.exp(w[14] * (1 - requestRetention));
}

function nextInterval(s) {
    const interval = Math.round(s * 9 * (1 / requestRetention - 1));
    return Math.min(Math.max(interval, 1), maximumInterval);
}

export function review(reviewState, rating) {
    const state = reviewState?.state ?? STATE_NEW;
    const difficulty = reviewState?.difficulty ?? 0.0;
    const stability = reviewState?.stability ?? 0.0;
    const reps = reviewState?.reps ?? 0;
    const lapses = reviewState?.lapses ?? 0;
    
    let elapsedDays = 0;
    if (state !== STATE_NEW) {
        const lastReviewAt = reviewState?.last_review_at ? new Date(reviewState.last_review_at) : new Date();
        const now = new Date();
        const diffTime = now.getTime() - lastReviewAt.getTime();
        elapsedDays = Math.max(0, Math.floor(diffTime / (1000 * 60 * 60 * 24)));
    }

    let newStability = stability;
    let newDifficulty = difficulty;
    let newState = state;

    if (state === STATE_NEW) {
        newDifficulty = initDifficulty(rating);
        newStability = initStability(rating);
        
        if (rating === RATING_EASY) {
            newState = STATE_REVIEW;
        } else {
            newState = STATE_LEARNING;
        }
    } else if (state === STATE_LEARNING || state === STATE_RELEARNING) {
        newDifficulty = nextDifficulty(difficulty, rating);
        newStability = shortTermStability(stability, rating);
        
        if (rating === RATING_GOOD || rating === RATING_EASY) {
            newState = STATE_REVIEW;
        } else {
            newState = state;
        }
    } else if (state === STATE_REVIEW) {
        newDifficulty = nextDifficulty(difficulty, rating);
        
        if (rating === RATING_AGAIN) {
            newStability = nextForgetStability(newDifficulty, stability, elapsedDays);
            newState = STATE_RELEARNING;
        } else {
            newStability = nextRecallStability(newDifficulty, stability, elapsedDays, rating);
            newState = STATE_REVIEW;
        }
    }

    let interval = nextInterval(newStability);
    let scheduled_minutes = 0;
    
    if (newState === STATE_LEARNING || newState === STATE_RELEARNING) {
        interval = 0;
        if (rating === RATING_AGAIN) scheduled_minutes = 1;
        else if (rating === RATING_HARD) scheduled_minutes = 5;
        else if (rating === RATING_GOOD) scheduled_minutes = 30;
        else scheduled_minutes = 60;
    } else {
        if (state === STATE_NEW && rating === RATING_EASY) {
            interval = 1;
        }
    }

    return {
        state: newState,
        scheduled_days: interval,
        scheduled_minutes: scheduled_minutes
    };
}

export default {
    review
};
