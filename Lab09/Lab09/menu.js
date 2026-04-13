const foodItems=[
    {
        id:1,
        name:"Burger",
        price:120,
        image:"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGxr-7yspU0NioDU98qKBsIqcDjibBTsJCwA&s"
    },
    {
        id:2,
        name:"Pizza",
        price:250,
        image:"https://img.freepik.com/free-photo/pizza-pizza-filled-with-tomatoes-salami-olives_140725-1200.jpg?semt=ais_user_personalization&w=740&q=80"

    },
    {
         id: 3,
        name: "Biryani",
        price: 180,
        image:"https://i0.wp.com/binjalsvegkitchen.com/wp-content/uploads/2025/05/Veg-Kofta-Biryani-H1.jpg?fit=600%2C900&ssl=1"

    }
];

const menuContainer=document.getElementById("menuContainer");

foodItems.forEach(item=>{
    const card=document.createElement("div");
    card.classList.add("card");
    card.innerHTML=`
    <a href="placeOrder.html?id=${item.id}" class="card-link">
        <img src="${item.image}"></img>
        <h3>${item.name}</h3>
        <p>>₹${item.price}</p>
    </a>
    <button onclick="addToCart(${item.id})" id="button">Add</button>`;
    menuContainer.appendChild(card);

});

let cart=[];

function addToCart(itemId){
    const selectedItem=foodItems.find(item=>item.id===itemId);
    cart.push(selectedItem);
    alert(`${selectedItem.name}added to cart 🛒`);
}