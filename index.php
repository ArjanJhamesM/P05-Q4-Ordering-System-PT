<?php
    session_start();


    $Order = []; // Array implementation


    // Handles logic related to the quantity of all order items
    function Modify_Order_Quantity($Main_Quantity_Variable, $Quantity_Add_Button, $Quantity_Subtract_Button) {

        // Because variables won't persist after pressing submit-type buttons 🤡
        if (!isset($_SESSION[$Main_Quantity_Variable])) { // i'm tired of this shit
            $_SESSION[$Main_Quantity_Variable] = 1;
        }

        // Logic for modifying the quantity of the order item
        if (isset($_POST[$Quantity_Add_Button])) {
            $_SESSION[$Main_Quantity_Variable] += 1;
        }

        if (isset($_POST[$Quantity_Subtract_Button])) {
            if ($_SESSION[$Main_Quantity_Variable] > 1) {
                $_SESSION[$Main_Quantity_Variable] -= 1;
            }
        }

        return $_SESSION[$Main_Quantity_Variable]; // Quantity after all the logic for modifying it
    }

    // Adds all order items to the array so they can be referenced in the order summary
    function Add_Order_Selection_And_Quantity_To_Array($Order_Item_Checkbox_Name, $Main_Quantity_Variable) {
        if (isset($_POST[$Order_Item_Checkbox_Name])) {
            $_SESSION["Order"][$_POST[$Order_Item_Checkbox_Name]] = $Main_Quantity_Variable;
        }
    }

    // Keeps the checkboxes ticked when modifying the quantity, when it has been previously been ticked, or both
    function Keep_Checkbox_On_Quantity_Change($Quantity_Add_Button, $Quantity_Subtract_Button, $Order_Item_Checkbox_Name) {
        if (isset($_POST[$Quantity_Add_Button]) ||
            isset($_POST[$Quantity_Subtract_Button]) ||
            isset($_POST[$Order_Item_Checkbox_Name])) {
            
                return "checked";
        }
        else {
            return "";
        }
    }
    

    $Mcdo_Chicken_Quantity = Modify_Order_Quantity(
        Main_Quantity_Variable: "Mcdo_Chicken_Quantity",
        Quantity_Add_Button: "mcdo-chicken-quantity-add",
        Quantity_Subtract_Button: "mcdo-chicken-quantity-subtract");

    $Jollibee_Chicken_Quantity = Modify_Order_Quantity(
        Main_Quantity_Variable: "Jollibee_Chicken_Quantity",
        Quantity_Add_Button: "jollibee-chicken-quantity-add",
        Quantity_Subtract_Button: "jollibee-chicken-quantity-subtract");

    $Popeyes_Chicken_Quantity = Modify_Order_Quantity(
        Main_Quantity_Variable: "Popeyes_Chicken_Quantity",
        Quantity_Add_Button: "popeyes-chicken-quantity-add",
        Quantity_Subtract_Button: "popeyes-chicken-quantity-subtract");

    $TwentyFour_Chicken_Quantity = Modify_Order_Quantity(
        Main_Quantity_Variable: "TwentyFour_Chicken_Quantity",
        Quantity_Add_Button: "twentyfour-chicken-quantity-add",
        Quantity_Subtract_Button: "twentyfour-chicken-quantity-subtract");
    

    // Compile all array addition logic
    function Add_All_Order_Selections() {
        // Declare global scope versions of quantity variables
        global $Mcdo_Chicken_Quantity;
        global $Jollibee_Chicken_Quantity;
        global $Popeyes_Chicken_Quantity;
        global $TwentyFour_Chicken_Quantity;

        Add_Order_Selection_And_Quantity_To_Array(
            Order_Item_Checkbox_Name: "mcdo-chicken", 
            Main_Quantity_Variable: $Mcdo_Chicken_Quantity
        );

        Add_Order_Selection_And_Quantity_To_Array(
            Order_Item_Checkbox_Name: "jollibee-chicken", 
            Main_Quantity_Variable: $Jollibee_Chicken_Quantity
        );

        Add_Order_Selection_And_Quantity_To_Array(
            Order_Item_Checkbox_Name: "popeyes-chicken", 
            Main_Quantity_Variable: $Popeyes_Chicken_Quantity
        );

        Add_Order_Selection_And_Quantity_To_Array(
            Order_Item_Checkbox_Name: "twentyfour-chicken", 
            Main_Quantity_Variable: $TwentyFour_Chicken_Quantity
        );
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>

</head>
<body>
    <h1>Food Ordering System</h1>

    <form method="post">
        <!-- <input type="checkbox" value="McDo Chicken" name="mcdo-chicken"> -->
        <input type="checkbox" value="McDo Chicken" name="mcdo-chicken" <?php echo Keep_Checkbox_On_Quantity_Change(Quantity_Add_Button: "mcdo-chicken-quantity-add", Quantity_Subtract_Button: "mcdo-chicken-quantity-subtract", Order_Item_Checkbox_Name: "mcdo-chicken"); ?>>
        <label for="mcdo-chicken">McDo Chicken</label>
        <button type="submit" value="mcdo-chicken-quantity-subtract" name="mcdo-chicken-quantity-subtract">-</button>
        <input type="number" min="1" value="<?php echo $Mcdo_Chicken_Quantity; ?>" name="mcdo-chicken-quantity">
        <button type="submit" value="mcdo-chicken-quantity-add" name="mcdo-chicken-quantity-add">+</button>
        <br>
        <input type="checkbox" value="Jollibee Chicken" name="jollibee-chicken" <?php echo Keep_Checkbox_On_Quantity_Change(Quantity_Add_Button: "jollibee-chicken-quantity-add", Quantity_Subtract_Button: "jollibee-chicken-quantity-subtract", Order_Item_Checkbox_Name: "jollibee-chicken"); ?>>
        <label for="jollibee-chicken">Jollibee Chicken</label>
        <button type="submit" value="jollibee-chicken-quantity-subtract" name="jollibee-chicken-quantity-subtract">-</button>
        <input type="number" min="1" value="<?php echo $Jollibee_Chicken_Quantity; ?>" name="jollibee-chicken-quantity">
        <button type="submit" value="jollibee-chicken-quantity-add" name="jollibee-chicken-quantity-add">+</button>
        <br>
        <input type="checkbox" value="Popeyes Chicken" name="popeyes-chicken" <?php echo Keep_Checkbox_On_Quantity_Change(Quantity_Add_Button: "popeyes-chicken-quantity-add", Quantity_Subtract_Button: "popeyes-chicken-quantity-subtract", Order_Item_Checkbox_Name: "popeyes-chicken"); ?>>
        <label for="popeyes-chicken">Popeyes Chicken</label>
        <button type="submit" value="popeyes-chicken-quantity-subtract" name="popeyes-chicken-quantity-subtract">-</button>
        <input type="number" min="1" value="<?php echo $Popeyes_Chicken_Quantity; ?>" name="popeyes-chicken-quantity">
        <button type="submit" value="popeyes-chicken-quantity-add" name="popeyes-chicken-quantity-add">+</button>
        <br>
        <input type="checkbox" value="24 Chicken" name="twentyfour-chicken" <?php echo Keep_Checkbox_On_Quantity_Change(Quantity_Add_Button: "twentyfour-chicken-quantity-add", Quantity_Subtract_Button: "twentyfour-chicken-quantity-subtract", Order_Item_Checkbox_Name: "twentyfour-chicken"); ?>>
        <label for="twentyfour-chicken">24 Chicken</label>
        <button type="submit" value="twentyfour-chicken-quantity-subtract" name="twentyfour-chicken-quantity-subtract">-</button>
        <input type="number" min="1" value="<?php echo $TwentyFour_Chicken_Quantity; ?>" name="twentyfour-chicken-quantity">
        <button type="submit" value="twentyfour-chicken-quantity-add" name="twentyfour-chicken-quantity-add">+</button>
        <br><br>
        <input type="submit" name="submit-button">
    </form>

    <br><h2>Order summary</h2>

    <?php
        if (isset($_POST["submit-button"])) {
            $_SESSION["Order"] = []; // Reset previous selection for new selection
    
            Add_All_Order_Selections();
            
            // List all key-value pairs in array
            // Quantity as value and Order item as key
            foreach ($_SESSION["Order"] as $Order_Item => $Order_Quantity) {
                echo $Order_Quantity . "x " . $Order_Item . "<br>";
            }
        }
    ?>
</body>
</html>