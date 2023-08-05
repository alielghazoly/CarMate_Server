class Navbar extends HTMLElement {
  constructor() {
    super();
    this.innerHTML = `
   <header>
    <div class="nav-info">
      <h1>Car Mate</h1>


    </div>

   
  </header>
   `;
  }
}

customElements.define("nav-bar", Navbar);
let card = document.querySelector(".card"); //declearing profile card element
let displayPicture = document.querySelector(".display-picture"); //declearing profile picture

displayPicture.addEventListener("click", function () {
  //on click on profile picture toggle hidden class from css
  card.classList.toggle("hidden");
});
