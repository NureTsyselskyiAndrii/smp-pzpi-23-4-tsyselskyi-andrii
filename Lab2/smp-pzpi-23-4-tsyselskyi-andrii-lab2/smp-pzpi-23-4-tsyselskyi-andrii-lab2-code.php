<?php

$products = [
    1 => ['name' => 'Молоко пастеризоване', 'price' => 12],
    2 => ['name' => 'Хліб чорний', 'price' => 9],
    3 => ['name' => 'Сир білий', 'price' => 21],
    4 => ['name' => 'Сметана 20%', 'price' => 25],
    5 => ['name' => 'Кефір 1%', 'price' => 19],
    6 => ['name' => 'Вода газована', 'price' => 18],
    7 => ['name' => 'Печиво "Весна"', 'price' => 14],
];

$cart = [];

$profile = [
    'name' => '',
    'age' => 0
];

echo "\n################################\n";
echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
echo "################################\n";
    
while (true) {
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
    echo "Введіть команду: ";
    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case '1':
            chooseProducts($products, $cart);
            break;
        case '2':
            showBill($products, $cart);
            break;
        case '3':
            setupProfile($profile);
            break;
        case '0':
            exit("Дякуємо за покупки! До побачення.\n");
        default:
            echo "ПОМИЛКА! Введіть правильну команду\n";
    }
}

function printTable($headers, $rows) {
    $widths = array_map(fn($h) => mb_strlen($h, 'UTF-8'), $headers);

    foreach ($rows as $row) {
        foreach ($row as $i => $val) {
            $widths[$i] = max($widths[$i], mb_strlen((string)$val, 'UTF-8'));
        }
    }

    foreach ($headers as $i => $head) {
        echo mb_str_pad($head, $widths[$i]) . '  ';
    }
    echo "\n";

    foreach ($rows as $row) {
        foreach ($row as $i => $val) {
            echo mb_str_pad((string)$val, $widths[$i]) . '  ';
        }
        echo "\n";
    }
}

function mb_str_pad($str, $len, $pad_char = ' ', $encoding = 'UTF-8') {
    $padLen = $len - mb_strlen($str, $encoding);
    return $padLen > 0 ? $str . str_repeat($pad_char, $padLen) : $str;
}


function chooseProducts($products, &$cart) {
    while (true) {
        $headers = ['№', 'НАЗВА', 'ЦІНА'];
        $rows = [];
        foreach ($products as $id => $prod) {
            $rows[] = [$id, $prod['name'], $prod['price']];
        }
        printTable($headers, $rows);
        echo "   -----------\n0  ПОВЕРНУТИСЯ\n";
        echo "Виберіть товар: ";
        $input = trim(fgets(STDIN));

        if ($input === '0') break;

        if (!array_key_exists($input, $products)) {
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
            continue;
        }

        $productName = $products[$input]['name'];
        echo "Вибрано: $productName\n";
        echo "Введіть кількість, штук: ";
        $quantity = trim(fgets(STDIN));

        if (!is_numeric($quantity) || $quantity < 0 || $quantity > 99) {
            echo "ПОМИЛКА! Введена некоректна кількість\n";
            continue;
        }

        if ($quantity == 0) {
            unset($cart[$input]);
            echo "ВИДАЛЯЮ ТОВАР З КОШИКА\n";
        }
        else{
            $cart[$input] = ($cart[$input] ?? 0) + $quantity;
        }
        
        if (empty($cart)) {
            echo "КОШИК ПОРОЖНІЙ\n";
        }
        else{
            echo "У КОШИКУ:\n";
            $headers = ['НАЗВА', 'КІЛЬКІСТЬ'];
            $rows = [];

            foreach ($cart as $id => $qty) {
                $rows[] = [$products[$id]['name'], $qty];
            }
            printTable($headers, $rows);
        }
        
        echo "\n";
        
    }
}

function showBill($products, $cart) {
    if (empty($cart)) {
        echo "КОШИК ПОРОЖНІЙ\n";
        echo "РАЗОМ ДО СПЛАТИ: 0\n";
        return;
    }

    $headers = ['№', 'НАЗВА', 'ЦІНА', 'КІЛЬКІСТЬ', 'ВАРТІСТЬ'];
    $rows = [];
    $i = 1;
    $total = 0;
    foreach ($cart as $id => $qty) {
        $name = $products[$id]['name'];
        $price = $products[$id]['price'];
        $cost = $price * $qty;
        $rows[] = [$i++, $name, $price, $qty, $cost];
        $total += $cost;
    }

    printTable($headers, $rows);

    echo "РАЗОМ ДО СПЛАТИ: $total\n";
    echo "\n";
}

function setupProfile(&$profile) {
    while (true) {
        echo "Ваше імʼя: ";
        $name = trim(fgets(STDIN));
        
        if (!preg_match('/^[а-яА-ЯёЁіІїЇєЄa-zA-Z\'\- ]+$/u', $name)) {
            echo "ПОМИЛКА! Імʼя може містити лише літери, апостроф «'», дефіс «-», пробіл\n\n";
            continue;
        }
        
        break;
    }

    while (true) {
        echo "Ваш вік: ";
        $age = trim(fgets(STDIN));
        if (!is_numeric($age) || $age < 7 || $age > 150) {
            echo "ПОМИЛКА! Користувач повинен мати вік від 7 та до 150 років.\n\n";
            continue;
        }
        break;
    }

    echo "\n";
    $profile['name'] = $name;
    $profile['age'] = (int)$age;
    echo "Ваше ім'я: {$profile['name']}\nВаш вік: {$profile['age']}\n";
    echo "\n";
}