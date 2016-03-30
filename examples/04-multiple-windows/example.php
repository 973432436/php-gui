<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputText;
use Gui\Components\Button;
use Gui\Components\Shape;
use Gui\Components\Window;
use Gui\Components\Checkbox;

$application = new Application([
    'title' => 'My PHP Desktop Application',
    'left' => 30,
    'top' => 40,
    'width' => 480,
    'height' => 300
]);

$application->on('start', function() use ($application) {

    $label = new Label([
        'text' => 'First Form',
        'top' => 10,
        'left' => 40,
        'fontSize' => 20,
    ]);

    $shape = new Shape([
        'backgroundColor' => '#EEE',
        'borderColor' => '#DDD',
        'left' => 40,
        'top' => 60,
        'width' => 400,
        'height' => 190
    ]);

    $data = [
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'company' => 'Company'
    ];

    $c = 0;
    $form = [];
    foreach ($data as $key => $value) {
        $calculatedTop = ($c++ * 35);

        ${'label' . ucfirst($key)} = new Label([
            'text' => $value . ':',
            'top' => 72 + $calculatedTop,
            'left' => 45,
            'fontSize' => 10,
        ]);

        ${'inputText' . ucfirst($key)} = new InputText([
            'top' => 65 + $calculatedTop,
            'left' => 110,
            'fontSize' => 25,
            'width' => 320
        ]);

        $form[] = [
            'key' => $key,
            'label' => $value,
            'object' => ${'inputText' . ucfirst($key)}
        ];
    }

    $labelOfAge = new Label([
        'text' => '+18:',
        'top' => 208,
        'left' => 45,
        'fontSize' => 10,
    ]);

    $checkboxOfAge = new Checkbox([
        'top' => 205,
        'left' => 110
    ]);

    $form[] = [
        'key' => 'ofAge',
        'label' => '+18',
        'object' => $checkboxOfAge
    ];

    $button = new Button([
        'value' => 'Save',
        'top' => 240,
        'left' => 40,
        'width' => 400
    ]);

    $button->on('click', function () use ($form) {
        $window = new Window([
            'title' => 'Form1 Info',
            'width' => 400,
            'height' => 400,
        ]);

        $c = 0;
        foreach ($form as $value) {
            $calculatedTop = ($c++ * 35);

            ${'label' . ucfirst($value['key'])} = new Label(
                [
                    'text' => $value['label'] . ':',
                    'top' => 10 + $calculatedTop,
                    'left' => 30,
                    'fontSize' => 10,
                ],
                $window
            );

            $objValue = null;

            if ($value['object'] instanceof InputText) {
                $objValue = $value['object']->getValue();
            } elseif ($value['object'] instanceof Checkbox) {
                $objValue = $value['object']->getChecked() ? 'Yes' : 'No';
            }

            ${$value['key']} = new Label(
                [
                    'text' => $objValue,
                    'top' => 10 + $calculatedTop,
                    'left' => 100,
                    'fontSize' => 10,
                ],
                $window
            );
        }
    });
});

$application->run();
