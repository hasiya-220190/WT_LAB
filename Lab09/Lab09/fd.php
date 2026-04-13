
<?php
session_start();
$auth_uri = "google_Oauth.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Ordering | Restaurants</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

      /*  body {
            background-color: #f5f5f5;
        }
            */

        /* Search bar */
        header {
            background-color: #d71372;
            padding: 15px;
            text-align: center;
        }

        header input {
            width: 60%;
            padding: 10px;
            border-radius: 20px;
            border: none;
            outline: none;
            font-size: 16px;
        }

        /* Suggestion section */
        .suggestion {
            background-color: #fff;
            margin: 20px auto;
            padding: 20px;
            width: 90%;
            border-radius: 10px;
            text-align: center;
        }

        .suggestion h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .suggestion p {
            color: #666;
        }

        /* Restaurant cards */
        .restaurants {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            text-decoration: none;
            color: black;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-content h3 {
            margin-bottom: 5px;
            color: #222;
        }

        .rating {
            color: #fff;
            background-color: #28a745;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .card-content p {
            color: #555;
            font-size: 14px;
        }
        .items img{
             width: 100%;
             height: 160px;
             object-fit: cover;
             border-radius: 8px;
        }
        .suggestion{
            display:grid;
             grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .items {
           text-align: center;
           background: white;
           border-radius: 10px;
           padding: 10px;
}
.items p{
    margin-top:8px;
    font-weight:bold;
}
.items:hover{
     transform: scale(1.03);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}
.heading{
    text-align:center;
}
.headed:hover{
    transform: scale(1.03);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    font-weight:bold;
}
.google{
    text-align:right;
}
    </style>
</head>
<body>
    <script>
        let selectedItem="";
        let selectedPrice=0;
        function selectItem(itemName,price){
            selectedItem=itemName;
            selectedPrice=price;
            alert("You selected:"+itemName);
        }
    </script>
    <!-- Search Bar -->
 <header>
<?php if(isset($_SESSION['username'])): ?>
    Welcome <?= htmlspecialchars($_SESSION['username']) ?> |
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="<?= $auth_uri ?>">Login with Google</a> |
    <a href="login.php">Normal Login</a>
<?php endif; ?>
</header>


    <!-- Suggestion for new users -->
    <div class="suggestion">
        <a href="placeOrder.html" class="order" onclick="selectItem('Dosa',45)">
        <div class="items">
        <img src="https://www.cookwithmanali.com/wp-content/uploads/2020/05/Masala-Dosa.jpg" alt="dosa" >
        <p class="name"><b>Dosa with chutney</b></p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('Idly',20)">
        <div class="items">
            <img src="https://miro.medium.com/1*nfbDiVFxBQGys61H7X7B1A.jpeg" alt="Idly">
            <p>Idly</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('Mysore Bonda',35)">
        <div class="items">
            <img src="https://revisfoodography.com/wp-content/uploads/2017/02/mysore-bonda-main-500x375.jpg" alt="Mysore Bonda">
            <p>Mysore Bonda</p>
        </div>
        </a>
        <a  href="placeOrder.html" class="order" onclick="selectItem('Biryani',160)">
        <div class="items">
            <img src="https://ministryofcurry.com/wp-content/uploads/2024/06/chicken-biryani-5.jpg" alt="Biryani">
            <p>Biryani</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('chicken lolipop',100)">
        <div class="items">
            <img src="https://www.cookwithkushi.com/wp-content/uploads/2022/01/best_chicken_lollipop_drums_of_chicken.jpg" alt="chicken lolipop">
            <p>Chicken lolipop</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('fried rice',65)">
        <div class="items">
            <img src="https://www.onceuponachef.com/images/2023/12/Fried-Rice-Hero-12.jpg" alt="fried rice">
            <p>Fried Rice</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('maggie',20)">
        <div class="items">
            <img src="https://i.pinimg.com/736x/2e/ca/78/2eca785867f946992b0b7fe4fb118f4f.jpg" alt="maggie">
            <p>Maggie</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('vada',40)">
        <div class="items">
            <img src="https://myfoodstory.com/wp-content/uploads/2022/09/Medu-Vada-2.jpg" alt="vada">
            <p>Vada</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('Sambar Rice',85)">
        <div class="items">
            <img src="https://i2.wp.com/cookingfromheart.com/wp-content/uploads/2021/01/Sambar-Sadam-2.jpg?fit=684%2C1024&ssl=1" alt="Sambar Rice">
            <p>Sambar rice</p>
        </div>
        </a>
        <a href="placeOrder.html" class="order" onclick="selectItem('poori',25)">
        <div class="items">
            <img src="https://cdn.pixabay.com/photo/2016/11/23/18/31/indian-food-1854247_1280.jpg" alt="poori">
            <p>Poori</p>
        </div>
        </a>
    </div>
    <div>
    
    </div>
    <!-- Restaurant List -->
     <section class="heading"><h2>Discover the best restaurants near you and order your favorite food easily!</h2></section>
    <section class="restaurants">
        
        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Spicy.jpg" alt="Restaurant 1">
            <div class="card-content">
                <h3>Spicy Hub</h3>
                <span class="rating">4.5 ★</span>
                <p>North Indian, Chinese, Biryani</p>
            </div>
        </a>

        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\green.jpg" alt="Restaurant 2">
            <div class="card-content">
                <h3>Green Leaf</h3>
                <span class="rating">4.2 ★</span>
                <p>South Indian, Veg Meals</p>
            </div>
        </a>

        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Burger.jpg" alt="Restaurant 3">
            <div class="card-content">
                <h3>Burger Town</h3>
                <span class="rating">4.0 ★</span>
                <p>Burgers, Fast Food, Snacks</p>
            </div>
        </a>

        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Sweet.jpg" alt="Restaurant 4">
            <div class="card-content">
                <h3>Sweet Cravings</h3>
                <span class="rating">4.7 ★</span>
                <p>Desserts, Ice Cream, Bakery</p>
            </div>
        </a>
        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\TasteT.jpg" alt="Restaurant 5">
            <div class="card-content">
                <h3>Taste Town</h3>
                <span class="rating">4.3 ★</span>
                <p>Fried rice,Chilly chicken,juices</p>
            </div>
        </a>
         <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Junction.jpg" alt="Restaurant 6">
            <div class="card-content">
                <h3>Flavour Junction</h3>
                <span class="rating">4.5 ★</span>
                <p>Fast food,Sambar Rice,Drinks</p>
            </div>
        </a>
         <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Hub.jpg" alt="Restaurant 7">
            <div class="card-content">
                <h3>The Hungry Hub</h3>
                <span class="rating">4.4 ★</span>
                <p>Fried rice,Chilly chicken,juices</p>
            </div>
        </a>
         <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Royal.jpg" alt="Restaurant 8">
            <div class="card-content">
                <h3>The Royal Bites</h3>
                <span class="rating">4.9 ★</span>
                <p>Fried rice,Chilly chicken,juices</p>
            </div>
        </a>
        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="C:\Users\ASWANI DURGA\OneDrive\Desktop\webpics\Quick.jpg" alt="Restaurant 9">
            <div class="card-content">
                <h3>Quick cravings</h3>
                <span class="rating">4.1 ★</span>
                <p>Fast food,Sambar Rice,Drinks</p>
            </div>
        </a>
        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbDxRZwnnWYDe0sVnlCT7CNni9S831R30vjQ&s" alt="Restaurant 10">
            <div class="card-content">
                <h3>Bite Rush</h3>
                <span class="rating">4.3 ★</span>
                <p>Fast food,Sambar Rice,Drinks</p>
            </div>
        </a>
        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSB1tqFT7kGDcOhvQvJ0pWq9DB0J4lOsBd_VA&s" alt="Restaurant 11">
            <div class="card-content">
                <h3>dragon wok</h3>
                <span class="rating">4.1 ★</span>
                <p>Fast food,Sambar Rice,Drinks</p>
            </div>
        </a>
        <a href="C:\Users\ASWANI DURGA\OneDrive\Desktop\FoodDeliveryApp\menu.html" class="card">
            <img src="https://content3.jdmagicbox.com/comp/vijayawada/b4/0866px866.x866.220405203829.j9b4/catalogue/asian-food-bowl-restaurant-gurunanak-colony-road-auto-nagar-vijayawada-restaurants-vzu5aynfoj.jpg" alt="Restaurant 12">
            <div class="card-content">
                <h3>Asian Bowl</h3>
                <span class="rating">4.8 ★</span>
                <p>Fast food,Sambar Rice,Drinks</p>
            </div>
        </a>
       
    </section>

    <script>
fetch("http://localhost:3000/restaurants")
  .then(res => res.json())
  .then(data => {
    const container = document.querySelector(".restaurants");
    container.innerHTML = "";

    data.forEach(r => {
      const card = `
        <a href="menu.html?rid=${r.restaurant_id}" class="card">
          <img src="${r.image}" alt="${r.restaurant_name}">
          <div class="card-content">
            <h3>${r.restaurant_name}</h3>
            <span class="rating">${r.rating} ★</span>
            <p>${r.cuisines}</p>
          </div>
        </a>
      `;
      container.innerHTML += card;
    });
  })
  .catch(err => console.error("Fetch error:", err));
</script>


</body>
</html>
