  $("#seceneklerbutonu").click(function () {
    $("#seceneklerbolumu").toggle(800)
  });

  $("#paylasmabutonu").click(function () {
    metin1 = $(".not-sifresi").val();
    metin2 = $(".not-sifresi-tekrar").val();
    if (metin1!=metin2) {
      alert("Şifreler Aynı Değil")
    } else {
     $("#gondermebutonu").trigger("click")
    }
  });