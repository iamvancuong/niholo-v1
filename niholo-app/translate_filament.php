<?php

$resourcesPath = __DIR__ . '/app/Filament/Resources/';

$translations = [
    'Courses/CourseResource' => [
        'modelLabel' => 'Khóa học',
        'pluralModelLabel' => 'Danh sách Khóa học',
        'navigationGroup' => 'Học thuật',
    ],
    'Lessons/LessonResource' => [
        'modelLabel' => 'Bài học',
        'pluralModelLabel' => 'Danh sách Bài học',
        'navigationGroup' => 'Học thuật',
    ],
    'GrammarPoints/GrammarPointResource' => [
        'modelLabel' => 'Ngữ pháp',
        'pluralModelLabel' => 'Danh sách Ngữ pháp',
        'navigationGroup' => 'Dữ liệu học',
    ],
    'Cards/CardResource' => [
        'modelLabel' => 'Thẻ từ vựng',
        'pluralModelLabel' => 'Danh sách Thẻ',
        'navigationGroup' => 'Dữ liệu học',
    ],
];

foreach ($translations as $resourceName => $trans) {
    $path = $resourcesPath . $resourceName . '.php';
    if (!file_exists($path)) continue;

    $content = file_get_contents($path);

    $properties = "
    protected static ?string \$modelLabel = '{$trans['modelLabel']}';
    protected static ?string \$pluralModelLabel = '{$trans['pluralModelLabel']}';
    protected static ?string \$navigationGroup = '{$trans['navigationGroup']}';
";

    $content = preg_replace('/(protected static \?string \$navigationIcon = [^;]+;)/', "$1\n" . $properties, $content);

    file_put_contents($path, $content);
    echo "Updated $resourceName\n";
}
