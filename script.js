
let slideIndex = 0;
showSlides();
function showSlides() {
  let slides = document.getElementsByClassName("slide");
  for (let i = 0; i < slides.length; i++) { slides[i].style.display = "none"; }
  slideIndex++;
  if (slideIndex > slides.length) { slideIndex = 1; }
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 4000);
}


function openModal(product, price) {
  document.getElementById("modalTitle").innerText = product;
  document.getElementById("modalPrice").innerText = price;
  document.getElementById("paymentModal").style.display = "flex";
  document.getElementById("payName").value = "";
  document.getElementById("payEmail").value = "";
  document.getElementById("payCard").value = "";
}

function closeModal() {
  document.getElementById("paymentModal").style.display = "none";
}

function payNow(event) {
  event.preventDefault();
  let name = document.getElementById("payName").value;
  let email = document.getElementById("payEmail").value;
  let card = document.getElementById("payCard").value;
  if(name===""||email===""||card==="") {
    alert("Please fill all payment fields.");
    return false;
  }
  alert("Payment successful! Thank you, " + name + "!");
  closeModal();
}


function validateLogin() {
  let email = document.getElementById("loginEmail").value;
  let pass = document.getElementById("loginPass").value;
  if(email===""||pass===""){ alert("Please fill all fields."); return false; }
  alert("Login successful!"); return true;
}

function validateRegister() {
  let name=document.getElementById("regName").value;
  let email=document.getElementById("regEmail").value;
  let pass=document.getElementById("regPass").value;
  if(name===""||email===""||pass===""){ alert("Please fill all fields."); return false; }
  if(pass.length<6){ alert("Password must have at least 6 characters."); return false; }
  alert("Registration successful!"); return true;
}

function validateContact() {
  let name=document.getElementById("contactName").value;
  let email=document.getElementById("contactEmail").value;
  let message=document.getElementById("contactMessage").value;
  if(name===""||email===""||message===""){ alert("Please fill all fields."); return false; }
  alert("Message sent successfully!"); return true;
}
