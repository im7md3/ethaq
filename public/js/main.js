// open side bar
if (document.querySelector(".tog-nav")) {
  let toggSide = document.querySelectorAll(".tog-nav");
  let app = document.querySelector(".app");
  toggSide.forEach((tog)=> {
    tog.addEventListener("click",()=>{
        app.classList.toggle("colse-and-open");
      })
  })
}

// Click tog-show
if (document.querySelector(".tog-active")) {
  let togglesShow = document.querySelectorAll(".tog-active");
  togglesShow.forEach((e) => {
    e.addEventListener("click", (evt) => {
      let divActive = document.querySelector(e.getAttribute("data-active"));
      divActive.classList.toggle("active");
    });
  });
}
// Active List Header
if (document.querySelector(".main-header-login .list-item .item")) {
    let itemsHeader = document.querySelectorAll(".main-header-login .list-item .item");
    itemsHeader.forEach(item => {
        item.addEventListener("click",()=> {
            itemsHeader.forEach(e => e.classList.remove("active"));
            item.classList.add("active");
        });
    });
};

// pop-order
if (document.querySelector(".boxes-step .btn-pop")) {
  // Open Pop
  let btnsPopOrder = document.querySelectorAll(".boxes-step .btn-pop");
  btnsPopOrder.forEach((btn) => {
    btn.addEventListener("click", function () {
        if(document.querySelector(".boxes-step .box.active")) {
            document.querySelector(".boxes-step .box.active").classList.remove("active");
        }
      document
        .querySelector("." + btn.dataset.active)
        .classList.add("active");
      document.body.classList.add("overflow-hidden");
    });
  });
  // Close Pop
  let closePopOrder = document.querySelectorAll(".boxes-step .box .close");
  closePopOrder.forEach((close) => {
    close.addEventListener("click", () => {
      close.closest(".box").classList.remove("active");
      document.body.classList.remove("overflow-hidden");
    });
  });
}

// Count TextArea
function countText() {
  let countArea = event.target
      .closest(".parent-form-add")
      .querySelector(":scope .count-area");
  let theTextArea = event.target;
  let areaMaxLength = event.target.getAttribute("maxlength");
  countArea.innerHTML = `${areaMaxLength} / ${theTextArea.value.length}`;
}

// loader
const theLoader = document.querySelector("#loader");
if(theLoader) {
    document.body.style.overflow="hidden"
    window.addEventListener("load", () => {
        setTimeout(() => {
            document.body.style.overflow="auto"
            theLoader.classList.add("hidden-loader");
        }, 200);
    })
}

// make modal Bootstrap popup show without click
if(document.querySelector("#popup_show")) {
    let myModal = new bootstrap.Modal(document.getElementById("popup_show"));
    myModal.show();
}



if(document.querySelector(".tog-active")) {
    document.querySelector(".tog-active").addEventListener("click", (e) => {
        document.querySelector(".tog-active").classList.toggle("show")
    })
}


// Scroll Add btn-top Home
if (document.querySelector(".srl-top")) {
    window.addEventListener("scroll", () => {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var sLanding = document.querySelector(".landing");
        var btnTop = document.querySelector(".srl-top");
        if (winScroll >= sLanding.scrollHeight ) {
            btnTop.classList.add("active-btn")
        } else {
            btnTop.classList.remove("active-btn")
        }
        btnTop.addEventListener("click",()=> {
            window.scroll({
                top: 0,
                behavior: 'smooth'
              });
        })
    });
}
// print
if (document.getElementById("prt-content")) {
    const btnPrtContent = document.getElementById("btn-prt-content");
    btnPrtContent.addEventListener("click", printDiv);

    function printDiv() {
        const prtContent = document.getElementById("prt-content");
        newWin = window.open("");
        newWin.document.head.replaceWith(document.head.cloneNode(true));
        newWin.document.body.appendChild(prtContent.cloneNode(true));
        setTimeout(() => {
            newWin.print();
            newWin.close();
        }, 600);
    }
}

if(document.querySelector('.line-text')) {
    var txt = document.querySelectorAll('.line-text');
    txt.forEach((ele)=>{
        var eleText = ele.innerHTML.split("\n").join('\n</br>');
        let removeFirstAndLastBr = eleText.trim().split("");
        removeFirstAndLastBr.splice(0, 5);
        removeFirstAndLastBr.splice(removeFirstAndLastBr.length - 1 - 5, removeFirstAndLastBr.length - 1);
        ele.innerHTML = removeFirstAndLastBr.join("");
    })
}
