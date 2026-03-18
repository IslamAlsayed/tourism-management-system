<?php
$user = \Modules\Core\Entities\User::where('email', 'tawfiq@example.com')->first();
if ($user) {
    $user->password = bcrypt('12345678');
    $user->save();
    echo "Password updated successfully.";
} else {
    echo "User not found.";
}
