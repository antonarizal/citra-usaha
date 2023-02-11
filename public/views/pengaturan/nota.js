
function getNota(dataFaktur){
const Store = require("electron-store");
const store = new Store();
const numeral = require("numeral");
var db = new localdb("db_weringin");
const getFaktur = dataFaktur
var date = new Date();
console.log(store.get("namaToko"))
var spacer ="-"
var data = ""
const lebar = 40;

const fText = limitText(getFaktur.footer,lebar)
const footerText =  fText.split("\n")
console.log(footerText)
data += setText(store.get("namaToko"),lebar,"c") + "\n";
data += setText(store.get("alamat"),lebar,"c") + "\n";
data += setText(store.get("telp"),lebar,"c") + "\n";
data += "\n"
data += setText("NO. NOTA",10,"l");
data += ":"+getFaktur.faktur + "\n";
data += setText("TGL",10,"l");
data += ":"+getFaktur.date +  "  "+ time_format(date)   + "\n";
data += setText("KASIR",10,"l");
data += ":"+store.get("username") + "\n";
data += "\n" +spacer.repeat(lebar) +"\n"
data += setText("BARANG   HRG",15,"l");
data += setText("QTY",10,"l");
data += setText("TOTAL",15,"r");
data += "\n" +spacer.repeat(lebar) +"\n"
$.each( getFaktur.listBarang , function( idx, val ) {
  data += val.nama_barang +"\n";
  data += setText(numeral(val.harga).format("0,0"),15,"l");
  data += setText("x"+val.qty,10,"l");
  data += setText(numeral(val.total).format("0,0"),15,"r");
  data += "\n" ;
});
data += spacer.repeat(lebar) +"\n"
data += setText("TOTAL :",25,"r");
data += setText(numeral(getFaktur.total).format("),0"),15,"r");
data +="\n"
data += setText("DIBAYAR :",25,"r");
data += setText(numeral(getFaktur.dibayar).format("),0"),15,"r");
data +="\n"
data += setText("KEMBALI :",25,"r");
data += setText(numeral(getFaktur.kembali).format("),0"),15,"r");
data +="\n"
data +="\n"
data += spacer.repeat(lebar) +"\n"
$.each( footerText , function( id, txt ) {
  data += setText(txt,lebar,"c")+"\n";
})
data +="\n"
console.log(store.get("footer_text"))

return data;
}
// data += setText("BARANG YANG SUDAH DIBELI TIDAK DAPAT DITUKAR/DIKEMBALIKAN",40,"c");


function limitText(text,charlimit){
  var lines = text.split('\n');
	for (var i = 0; i < lines.length; i++) {
		if (lines[i].length <= charlimit) continue;
		var j = 0; space = charlimit;
		while (j++ <= charlimit) {
			if (lines[i].charAt(j) === ' ') space = j;
		}
		lines[i + 1] = lines[i].substring(space + 1) + (lines[i + 1] || "");
		lines[i] = lines[i].substring(0, space);
	}
	text = lines.slice(0, 10).join('\n');
  return text;
}

function setText(text,lebar,position="l"){
  let space=" ";
  let lText=text.length;
  let sisa = lebar-lText;
  let tulis;
  if(lText > lebar){
    text = limitText(text,lebar)
  }
  if(position == "l"){
    tulis = text + "" + space.repeat(sisa)
  }
  else
  if(position == "r"){
    tulis = space.repeat(sisa) + text
  }
  else
  if(position == "c"){
    if(sisa>0){
      sisa = sisa/2
      tulis = space.repeat(sisa) + text + space.repeat(sisa)
    }else{
      tulis = text

    }

  }
  return tulis;

}
// 10,000,000 = 15
// x1000 = 10
// x1000 = 155

