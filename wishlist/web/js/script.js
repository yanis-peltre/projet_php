'use strict';

function verifCase(){
	// On récupère tous les groupes
    let cases=document.querySelectorAll("li > input");
    
    // On compte les cases cochées parmi les groupes
    cases.forEach((ma_case) => {
        if(ma_case.checked){
            return true;
        }
    });
	
	return false;
}

window.addEventListener('load', function(){
	let cases=document.querySelector("li > input");
	let envoi=document.getElementById("envoi");
	
	//envoi.disabled=true;
	
	cases.addEventListener("click",(envoi)=>{
		//Si bonChoix()===false, n'envoi pas le formulaire
		if(verifCase()){
			envoi.disabled=false;
		}
		else{
			envoi.disabled=true;
		}
	});
});



