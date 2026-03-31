// Task 1: Variables
var company = "My Startup";
let year = 2026;
const founder = "You";

console.log(company, year, founder);

// Task 2: Functions
function add(a, b) {
    return a + b;
}

const subtract = (a, b) => a - b;

console.log(add(5, 3));
console.log(subtract(10, 4));

// Task 3: Built-in functions
alert("Welcome to our website!");

function askName() {
    let name = prompt("Enter your name:");
    alert("Hello " + name);
}

// Task 4: DOM Manipulation
function changeText() {
    document.getElementById("text").innerText = "Text Changed!";
}

// Task 5: Styling
let toggle = false;
function changeStyle() {
    let el = document.getElementById("text");

    if (!toggle) {
        el.style.color = "white";
        el.style.background = "black";
        el.style.fontSize = "20px";
        toggle = true;
    } else {
        el.style.color = "black";
        el.style.background = "white";
        toggle = false;
    }
}

// Task 6: Events
document.getElementById("title").onmouseover = function () {
    this.style.color = "red";
};

document.getElementById("title").onmouseout = function () {
    this.style.color = "black";
};

function handleSubmit(event) {
    event.preventDefault();
    console.log("Form Submitted");
}

// Task 7: Interactive + Validation
function printPage() {
    window.print();
}