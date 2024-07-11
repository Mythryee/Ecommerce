<?php
    include "Components/_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nike Shoes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .imagecontainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        .product-container {
            width: 300px;
            height: 480px; /* Increased height to accommodate wishlist button */
            border: 1px solid #ccc;
            margin: 20px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Ensure position context for absolute positioning */
        }
        .product-title {
            font-size: 20px;
            margin: 10px 0;
            text-align: center;
        }
        .product-rating {
            font-style: italic;
            margin-top: auto;
        }
        .product-photo img {
            width: 200px;
            height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .wishlist-btn {
            position: absolute;
            top: 10px; /* Adjusted position to bottom */
            right: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 16px;
        }
        .wishlist-container {
            margin-top: 20px;
            width: 100%; /* Ensure full width */
            max-width: 1200px; /* Adjust as per your design */
            margin: 20px auto; /* Center align */
        }
        .wishlist-container h2 {
            text-align: center;
        }
        .wishlist-container ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .wishlist-container li {
            margin: 10px;
            text-align: center;
        }
        .wishlist-container button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="imagecontainer">
        <?php
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://real-time-product-search.p.rapidapi.com/search?q=Nike%20shoes&country=us&language=en&page=1&limit=30&sort_by=BEST_MATCH&product_condition=ANY&min_rating=ANY",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: real-time-product-search.p.rapidapi.com",
                    "x-rapidapi-key: 3696befd11mshaaaeab49fcaf07bp1bf080jsn71868f139c5c"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response, true);

                if (isset($data['data']) && is_array($data['data'])) {
                    foreach ($data['data'] as $product) {
                        $product_id = $product['product_id'] ?? '';
                        $product_title = $product['product_title'] ?? '';
                        $product_photos = $product['product_photos'] ?? [];
                        $rating = $product['rating'] ?? '';
                        $price = $product['price'] ?? '';

                        echo '<div class="product-container">';
                        
                        // Display product photos
                        echo '<div class="product-photo">';
                        if (!empty($product_photos)) {
                            echo '<img src="' . $product_photos[0] . '" alt="Product Image">';
                        } else {
                            echo '<img src="placeholder.jpg" alt="Product Image">';
                        }
                        echo '</div>';
                        
                        // Display product title
                        echo '<h2 class="product-title">' . $product_title . '</h2>';
                        
                        // Display product rating and price
                        echo '<p class="product-rating">Rating: ' . 4 . '</p>';
                        echo '<p class="product-rating">Price: $' . 1000 . '</p>';
                        
                        // Wishlist button with dynamic text based on localStorage
                        echo '<button class="wishlist-btn" onclick="toggleWishlist(\'' . $product_id . '\')" id="wishlist-btn-' . $product_id . '">' . (in_array($product_id, get_wishlist()) ? 'Remove from Wishlist' : 'Add to Wishlist') . '</button>';
                        
                        echo '</div>';
                    }
                } else {
                    echo "No products found.";
                }
            }
            
            // Function to get wishlist items from localStorage
            function get_wishlist() {
                return json_decode($_COOKIE['wishlist'] ?? '[]', true);
            }
        ?>
    </div>

    <div class="wishlist-container">
        <h2>My Wishlist</h2>
        <ul id="wishlist">
            <?php
                // Display wishlist items from localStorage
                foreach (get_wishlist() as $product_id) {
                    echo '<li id="wishlist-item-' . $product_id . '">Product ID: ' . $product_id . '</li>';
                }
            ?>
        </ul>
    </div>

    <script>
        // Function to toggle product in wishlist
        function toggleWishlist(productId) {
            let wishlist = get_wishlist();
            let index = wishlist.indexOf(productId);
            if (index === -1) {
                wishlist.push(productId);
                document.getElementById('wishlist-btn-' + productId).textContent = 'Remove from Wishlist';
                displayProductInWishlist(productId); // Display product in wishlist
            } else {
                wishlist.splice(index, 1);
                document.getElementById('wishlist-btn-' + productId).textContent = 'Add to Wishlist';
                removeProductFromWishlist(productId); // Remove product from wishlist display
            }
            document.cookie = 'wishlist=' + JSON.stringify(wishlist); // Set the updated wishlist in cookie
        }

        // Function to display product details in wishlist
        function displayProductInWishlist(productId) {
            // Simulating product details for demonstration
            let productDetails = {
                title: 'Nike Air Max',
                rating: '4.5',
                price: '$150',
                image: 'https://example.com/product_image.jpg' // Replace with actual product image URL
            };

            let wishlistContainer = document.getElementById('wishlist');
            let listItem = document.createElement('li');
            listItem.id = 'wishlist-item-' + productId;

            let productImage = document.createElement('img');
            productImage.src = productDetails.image;
            productImage.alt = 'Product Image';
            productImage.style.width = '100px'; // Adjust size as needed
            listItem.appendChild(productImage);

            let titleElement = document.createElement('p');
            titleElement.textContent = 'Title: ' + productDetails.title;
            listItem.appendChild(titleElement);

            let ratingElement = document.createElement('p');
            ratingElement.textContent = 'Rating: ' + productDetails.rating;
            listItem.appendChild(ratingElement);

            let priceElement = document.createElement('p');
            priceElement.textContent = 'Price: ' + productDetails.price;
            listItem.appendChild(priceElement);

            let removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.addEventListener('click', function() {
                removeFromWishlist(productId);
            });
            listItem.appendChild(removeButton);

            wishlistContainer.appendChild(listItem);
        }

        // Function to remove product from wishlist display
        function removeProductFromWishlist(productId) {
            let listItem = document.getElementById('wishlist-item-' + productId);
            if (listItem) {
                listItem.remove();
            }
        }

        // Function to remove product from wishlist
        function removeFromWishlist(productId) {
            let wishlist = get_wishlist();
            let index = wishlist.indexOf(productId);
            if (index !== -1) {
                wishlist.splice(index, 1);
                document.cookie = 'wishlist=' + JSON.stringify(wishlist); // Update the cookie
                removeProductFromWishlist(productId); // Remove from displayed wishlist
                document.getElementById('wishlist-btn-' + productId).textContent = 'Add to Wishlist'; // Update button text
            }
        }

        // Function to retrieve wishlist from cookie
        function get_wishlist() {
            return JSON.parse(getCookie('wishlist') || '[]');
        }

        // Helper function to get cookie by name
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Initialize displayed wishlist
        document.addEventListener('DOMContentLoaded', function() {
            // Display initial wishlist items
            let wishlist = get_wishlist();
            wishlist.forEach(productId => {
                displayProductInWishlist(productId);
            });
        });
    </script>

</body>
</html>
