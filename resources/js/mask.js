import Inputmask from "inputmask";
alert("aaaa");
// Aplica a máscara para valores monetários
Inputmask({ alias: "currency", prefix: "R$ ", suffix: "", radixPoint: ",", autoGroup: true }).mask(document.querySelectorAll(".money-mask"));