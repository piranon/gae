function PreviewImage() {
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("imageCategory").files[0]);
  oFReader.onload = function (oFREvent) {
    document.getElementById("area-inner-image").src = oFREvent.target.result;
    document.getElementById("area-inner-image").setAttribute('style', 'width:auto !important;');
    document.getElementById("pic-icon").style.display = "none";
  };
}
$('.date').datepicker({
  format: "yyyy-mm-dd",
  language: "th",
  autoclose: true,
  todayHighlight: true
});