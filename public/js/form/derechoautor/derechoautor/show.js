var tshow = document.querySelector("#wizard-create-app");
if (null !== tshow) {
    var nshow = [].slice.call(tshow.querySelectorAll(".btn-next")),
    cshow = [].slice.call(tshow.querySelectorAll(".btn-prev")),
    rshow = tshow.querySelector(".btn-submit");
    new Stepper(tshow, { linear: !1 })
}

//------------------------------------------------------------- Init
function init() { }