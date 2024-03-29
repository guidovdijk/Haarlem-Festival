<?php
include __DIR__.'/../../classes/autoloader.php';
class cartDisplay
{
    private cart $cart;

    public function __construct(cart $cart)
    {
        $this->cart = $cart;
    }
    
    public function render()
    {
        echo "<section class='container section page--cart' >
        <section class='row align-items-end page--cart__header'>
            <h1 style='margin-left:0px; padding-left:0px;' class='col-4 title title--page page--cart__title dance'>Your Cart</h1>"; 
            $steps = new steps(1);
            $steps->render();    
            echo "</section>
        <section class='page--cart__itemContainer'>
            <h2>Tickets</h2>";

        foreach($this->cart->__get('cartItems') as $cartItem)
        {
            $itemType = $cartItem->__get('itemType');
            $ticketPrice = $cartItem->getTotalPrice();
            $title = $cartItem->__get('title');
            $place = $cartItem->__get('address');
            $day = $cartItem->__get('day');
            $date = $cartItem->__get('date');
            $time = $cartItem->__get('time');
            $count = $cartItem->__get('count');
            $info = $cartItem->__get('additionalInfo');

            switch ($itemType)
            {
                //If the item is from different events, color of the cart item line changes accordingly
                case cartItemType::Jazz:
                    echo "
                    <section class='page--cart__jazzLine'>";
                    break;

                case cartItemType::Dance:
                    echo "
                    <section class='page--cart__danceLine'>";
                    break;

                case cartItemType::History:
                    echo "
                    <section class='page--cart__historyLine'>";
                    break;

                case cartItemType::Cuisine:
                    echo "
                    <section class='page--cart__cuisineLine'>";
                    break;
            }
            $cartItemIndex = array_search($cartItem, $this->cart->__get('cartItems'));
            echo "
            <form method='GET'>
                <section class='page--cart__itemInfoContainer'>
                <h1 class='title title--tetriary'>€ $ticketPrice</h1>
                <h1 class='title title--tetriary'>$title</h1>
                <p>$place</p>
                <p>$day, $date $time</p>";
                if($info != null)
                    echo "<p style='font-style: italic;'>Additional Info: $info</p>";
                
                    echo "
                    </section>
                <section class='page--cart__itemQuantityContainer'>";
                
                if($itemType == cartItemType::Cuisine)
                    echo "<p>Seats</p>";
                else
                    echo "<p>Quantity</p>";

                echo "
                    <input type='hidden' name='cartItemId' value='$cartItemIndex'>
                    <input class='title title--tetriary page--cart__quantityField' action='submit' name='quantity' value=$count>
                    <button class='page--cart__editButton' type='Submit' name='action' value='edit'>Change</button>
                    <button class='page--cart__removeButton' type='Submit' name='action' value='remove'>Remove</button>
                </section>
            </section>
            </form>
        ";
    }

        $totalPrice = $this->cart->getTotalPrice();
        $discount = $this->cart->getDiscount();
        $priceAfterDiscount = $this->cart->getPriceAfterDiscount();

        echo "
        </section>
        <section class='page--cart__totalPrice'>
            <h2>Total Price</h2>
            <section class ='page--cart__totalPriceColumn'>
                <h1 class='page--cart__totalPriceColumnText'>Tickets (incl BTW.):</h1>
                <h1 class='page--cart__totalPriceColumnText'>Book More Save More (Discount):</h1>
            </section>
            <section class='page--cart__totalPriceColumn'>
                <h1 class='page--cart__totalPriceColumnText'>€ $totalPrice</h1>
                <h1 class='page--cart__totalPriceColumnText'>- € $discount</h1>
            </section>
            <hr align='left' class='page--cart__totalPriceHr'>
            <section class='page--cart__totalPriceColumn'>
                <h1 class='page--cart__totalPriceColumnText'>Total Price:</h1>
            </section>
            <section class='page--cart__totalPriceColumn'>
                <h1 class='page--cart__totalPriceColumnText'>€ $priceAfterDiscount</h1>
            </section>
            <a href='../views/jazzEvent.php'><button class='page--cart__button'>Continue Shopping</button></a>
            <a href='../views/personaldetailspage.php' class='button page--cart__button'>Go to Payment</a>
        </section>
    </section>
        ";
    }

}

?>