var shortPass 	= 'Sei kreativ!'
var longPass 	= 'maximal 20 Zeichen'
var badPass 	= ''
var goodPass 	= ''
var strongPass 	= ''
function passwordStrength(password)
{
    score = 0 
    if (password.length < 1 ) { return '<div class="graph"><span id="gesamt" class="bar minifont minifont" style="width: 100%; solid #000000; background:none;">'+shortPass+'</span></div>' }
	if (password.length > 20 ) { return '<div class="graph"><span id="gesamt" class="bar minifont" style="width: 100%; solid #000000; background:none;">'+longPass+'</span></div>' }
    score += password.length * 4
    score += ( checkRepetition(1,password).length - password.length ) * 1
    score += ( checkRepetition(2,password).length - password.length ) * 1
    score += ( checkRepetition(3,password).length - password.length ) * 1
    score += ( checkRepetition(4,password).length - password.length ) * 1
    if (password.match(/(.*[0-9].*[0-9].*[0-9])/))  score += 5 
    if (password.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)) score += 5 
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  score += 5 
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  score += 10 
    if (password.match(/([!,@,#,$,%,^,&,*,?,_,~])/) && password.match(/([0-9])/))  score += 10 
    if (password.match(/([!,@,#,$,%,^,&,*,?,_,~])/) && password.match(/([a-zA-Z])/))  score += 10 
    if (password.match(/^\w+$/) || password.match(/^\d+$/) )  score -= 10 
    score *= 1.5
    if ( score < 0 )  score = 0 
    if ( score > 100 )  score = 100 
    if (score < 45 )  return '<div class="graph"><span id="gesamt" class="bar minifont" style="width: '+score+'%; solid #000000;">'+badPass+'</span></div>'
    if (score < 80 )  return '<div class="graph"><span id="gesamt" class="bar minifont" style="width: '+score+'%; solid #000000;">'+goodPass+'</span></div>'
    return '<div class="graph"><span id="gesamt" class="bar minifont" style="width: '+score+'%; solid #000000;">'+strongPass+'</span></div>'
}

function checkRepetition(pLen,str) {
    res = ""
    for ( i=0; i<str.length ; i++ ) {
        repeated=true
        for (j=0;j < pLen && (j+i+pLen) < str.length;j++)
            repeated=repeated && (str.charAt(j+i)==str.charAt(j+i+pLen))
        if (j<pLen) repeated=false
        if (repeated) {
            i+=pLen-1
            repeated=false
        }
        else {
            res+=str.charAt(i)
        }
    }
    return res
}