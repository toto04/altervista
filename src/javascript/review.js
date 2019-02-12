function openReview() {
  document.onkeyup = (e) => {
    if (e.key == "Escape") {
      closeReview();
    }
  }
  var review = document.getElementById('newReview').style;
  review.display = "block";
  timer = setTimeout(() => {
    review.opacity = 1;
  }, 1)
}

function closeReview() {
  document.onkeyup = ()=>{}
  var review = document.getElementById('newReview').style;
  review.opacity = 0;
  timer = setTimeout(() => {
    review.display = "none";
  }, 200)
}
