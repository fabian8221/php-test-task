<?php

// Example data structure
$guests = [
    [
        'guest_id' => 177,
        'guest_type' => 'crew',
        'first_name' => 'Marco',
        'middle_name' => null,
        'last_name' => 'Burns',
        'gender' => 'M',
        'guest_booking' => [
            [
                'booking_number' => 20008683,
                'ship_code' => 'OST',
                'room_no' => 'A0073',
                'start_time' => 1438214400,
                'end_time' => 1483142400,
                'is_checked_in' => true,
            ],
        ],
        'guest_account' => [
            [
                'account_id' => 20009503,
                'status_id' => 2,
                'account_limit' => 0,
                'allow_charges' => true,
            ],
        ],
    ],
    [
        'guest_id' => 10000113,
        'guest_type' => 'crew',
        'first_name' => 'Bob Jr ',
        'middle_name' => 'Charles',
        'last_name' => 'Hemingway',
        'gender' => 'M',
        'guest_booking' => [
            [
                'booking_number' => 10000013,
                'room_no' => 'B0092',
                'is_checked_in' => true,
            ],
        ],
        'guest_account' => [
            [
                'account_id' => 10000522,
                'account_limit' => 300,
                'allow_charges' => true,
            ],
        ],
    ],
    [
        'guest_id' => 10000114,
        'guest_type' => 'crew',
        'first_name' => 'Al ',
        'middle_name' => 'Bert',
        'last_name' => 'Santiago',
        'gender' => 'M',
        'guest_booking' => [
            [
                'booking_number' => 10000014,
                'room_no' => 'A0018',
                'is_checked_in' => true,
            ],
        ],
        'guest_account' => [
            [
                'account_id' => 10000013,
                'account_limit' => 300,
                'allow_charges' => false,
            ],
        ],
    ],
    [
        'guest_id' => 10000115,
        'guest_type' => 'crew',
        'first_name' => 'Red ',
        'middle_name' => 'Ruby',
        'last_name' => 'Flowers ',
        'gender' => 'F',
        'guest_booking' => [
            [
                'booking_number' => 10000015,
                'room_no' => 'A0051',
                'is_checked_in' => true,
            ],
        ],
        'guest_account' => [
            [
                'account_id' => 10000519,
                'account_limit' => 300,
                'allow_charges' => true,
            ],
        ],
    ],
    [
        'guest_id' => 10000116,
        'guest_type' => 'crew',
        'first_name' => 'Ismael ',
        'middle_name' => 'Jean-Vital',
        'last_name' => 'Jammes',
        'gender' => 'M',
        'guest_booking' => [
            [
                'booking_number' => 10000016,
                'room_no' => 'A0023',
                'is_checked_in' => true,
            ],
        ],
        'guest_account' => [
            [
                'account_id' => 10000015,
                'account_limit' => 300,
                'allow_charges' => true,
            ],
        ],
    ],
];

// Capture output buffering
ob_start();

echo "\n" . str_repeat("=", 50) . "\n";
echo "QUESTION 1 OUTPUT\n";
echo str_repeat("=", 50) . "\n\n";

include 'question1.php';
printNestedArray($guests);

echo "\n" . str_repeat("=", 50) . "\n";
echo "QUESTION 2 OUTPUT\n";
echo str_repeat("=", 50) . "\n\n";

include 'question2.php';
$sortedByLastName = sortNestedArray($guests, ['last_name']);
$sortedByLastNameAndAccountId = sortNestedArray($guests, ['last_name', 'account_id']);

echo "SORTED BY LAST NAME:\n";
echo str_repeat("-", 30) . "\n";
printNestedArray($sortedByLastName);

echo "\nSORTED BY LAST NAME AND ACCOUNT ID:\n";
echo str_repeat("-", 30) . "\n";
printNestedArray($sortedByLastNameAndAccountId);

echo "\n" . str_repeat("=", 50) . "\n";
echo "QUESTION 3 OUTPUT\n";
echo str_repeat("=", 50) . "\n\n";

include 'question3.php';

// Create test data for Question 3
$customer = new Customer('John', 'Doe');

// Add addresses
$address1 = new Address('123 Main St', null, 'Boston', 'MA', '02108');
$address2 = new Address('456 Park Ave', 'Apt 789', 'New York', 'NY', '10022');
$customer->addAddress($address1);
$customer->addAddress($address2);

// Create cart and add customer
$cart = new Cart();
$cart->setCustomer($customer);

// Add items
$item1 = new Item(1, 'Widget', 2, 9.99);
$item2 = new Item(2, 'Gadget', 1, 29.99);
$cart->addItem($item1);
$cart->addItem($item2);

// Set shipping address
$cart->setShippingAddress($address1);

// Display cart information
echo "CART INFORMATION:\n";
echo str_repeat("-", 30) . "\n";
printf("Customer:     %s\n", $cart->getCustomerName());
printf("Subtotal:     $%8.2f\n", $cart->getSubtotal());
printf("Tax:          $%8.2f\n", $cart->getTax());
printf("Shipping:     $%8.2f\n", $cart->getShippingCost());
echo str_repeat("-", 30) . "\n";
printf("Total:        $%8.2f\n", $cart->getTotal());

// Display customer addresses
echo "\nCUSTOMER ADDRESSES:\n";
echo str_repeat("-", 30) . "\n";
foreach ($cart->getCustomerAddresses() as $index => $address) {
    echo "Address " . ($index + 1) . ":\n";
    echo $address->getFullAddress() . "\n\n";
}

echo str_repeat("=", 50) . "\n";
echo "END OF OUTPUT\n";
echo str_repeat("=", 50) . "\n";

// Get the output buffer content
$output = ob_get_clean();

// Display the output in pre tags for proper formatting
echo '<pre>';
echo htmlspecialchars($output);
echo '</pre>';
?>