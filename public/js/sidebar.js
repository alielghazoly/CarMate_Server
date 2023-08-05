const template = document.createElement("template");

class Sidebar extends HTMLElement {
  constructor() {
    super();
    // const shadow = this.attachShadow({ mode: "open" });
    this.innerHTML = `  <div>
        <nav class="sidebar close">
          <i style="font-size: 15px" class="fa-solid fa-chevron-right toggle"></i>

          <div class="menu-bar">
            <div class="menu">
              <ul class="menu-links">
          
                <div>
                  <li data-rotate="180deg" class="contains-dropdown nav-link">
                    <a class="link-closed">
                    
                    <span class="text">Dashboard</span>
                      </a>
                  </li>
                  <div class="dropdown hidden">
                    <a href="">Create Device</a>
                    <a href="">Add New Model</a>
                  </div>
                </div>


              </ul>
            </div>
          </div>

        </nav>

        <div class="sidebar-part-two close">
          <div class="menu-bar">
            <div class="menu">


              <ul class="menu-links">
                <li class="nav-link">
                  <a style="padding-left: 0px;" class="link-closed">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20.907" height="24" viewBox="0 0 20.907 24">
                  <g id="icon" transform="translate(-20.975 -17.593)">
                  <path id="Path_46" data-name="Path 46"
                  d="M13.093-3148q-4.651,0-9.3,0a3.732,3.732,0,0,1-3.717-3.049,4.174,4.174,0,0,1-.069-.813Q0-3160,0-3168.128a3.74,3.74,0,0,1,3.243-3.835.37.37,0,0,0,.083-.037H14.578c.056.023.113.048.169.07a1.124,1.124,0,0,1,.718,1.255,1.116,1.116,0,0,1-1.087.922c-.7.009-1.407,0-2.11,0H3.9a1.512,1.512,0,0,0-1.651,1.641q0,8.106,0,16.214a1.514,1.514,0,0,0,1.651,1.642h4.46q2.973,0,5.945,0a1.123,1.123,0,0,1,1.118,1.478,1.109,1.109,0,0,1-1.041.769c-.179,0-.358,0-.537,0Zm.5-5.9a1.124,1.124,0,0,1,.077-1.581q1.222-1.23,2.452-2.452c.3-.3.6-.593.944-.94H8.279a1.138,1.138,0,0,1-1.149-.787,1.122,1.122,0,0,1,1.049-1.459c.609-.012,1.219,0,1.828,0h7.043c-.1-.1-.153-.164-.212-.222-1.06-1.061-2.125-2.117-3.18-3.182a1.118,1.118,0,0,1,.487-1.911,1.076,1.076,0,0,1,1.076.3c.433.428.862.861,1.293,1.291l3.944,3.943a1.144,1.144,0,0,1,0,1.814q-2.592,2.593-5.187,5.185a1.232,1.232,0,0,1-.867.381A1.084,1.084,0,0,1,13.593-3153.9Z"
                  transform="translate(20.974 3189.592)" fill="#f13c47" />
                  </g>
                  </svg>
                  <span style="color: #F13C47 !important; " class="text">LogOut</span>
                  </a>
                </li>

              </ul>
            </div>
          </div>
        </div>

      </div>
      `;
  }
}

customElements.define("side-bar", Sidebar);
const sidebar = document.querySelector("nav"),
  toggle = document.querySelector(".toggle"),
  lis = document.querySelectorAll(".nav-link"),
  dropdown = document.querySelector(".dropdown"),
  sidebarPartTwo = document.querySelector(".sidebar-part-two"),
  root = document.querySelector(":root");
console.log(sidebarPartTwo);
function showAndChangeLiBeforeArrow() {
  if (
    getComputedStyle(document.documentElement).getPropertyValue(
      "--beforeDisplay"
    ) === "none"
  ) {
    root.style.setProperty("--beforeDisplay", "block");
  } else {
    root.style.setProperty("--beforeDisplay", "none");
  }
}

showAndChangeLiBeforeArrow();
lis.forEach((li) => {
  if (li.classList.contains("contains-dropdown")) {
    li.parentNode?.children[1].style.setProperty(
      "--height",
      ` ${li.parentNode?.children[1].scrollHeight + 60}px`
    );
    console.log(`${li.parentNode?.children[1].scrollHeight}px`);
  }
});

toggle?.addEventListener("click", () => {
  sidebar.classList.toggle("close");
  dropdown.classList.add("hidden");
  showAndChangeLiBeforeArrow();
  sidebarPartTwo.classList.toggle("close");

  // e.target.parentNode?.children[1]?.classList.toggle("hidden");
  lis.forEach((li) => {
    li.children[0].classList.toggle("link-closed");
    li.addEventListener("click", (e) => {
      e.target.parentNode.children[1]?.classList?.toggle("hidden");
      if (!e.target.parentNode?.children[1]) return;
      if (e.target.parentNode?.children[1]?.classList.contains("hidden")) {
        e.target.style.setProperty("--beforeRotate", "90deg");
        e.target.style.setProperty("--marginTop", "0px");
      } else {
        e.target.style.setProperty("--beforeRotate", "0deg");
        e.target.style.setProperty("--marginTop", "0px");
      }
    });
  });
});
