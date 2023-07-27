function showComputeButton() {
  document.getElementById("computeBtn").style.display = "inline";

  document.getElementById("confirmBtn").style.display = "none";
}

$(document).ready(function () {
  $('[name="download_pdf"]').click(function () {
    $('#countdownModal').modal('show');

    var count = 5;
    var countdownTimer = setInterval(function () {
      $('#countdownTimer').text(count);
      if (count <= 0) {
        clearInterval(countdownTimer);
        window.location.href = "GradeTableDICT.php";
      }
      count--;
    }, 1000); 
  });
});