document.addEventListener('DOMContentLoaded', () => {

    //modal crear expediente
    
    const btn_modal_expediente = document.getElementById("btn_crear");
    const modal_expediente = document.getElementById("modal_expediente");
    const btn_cerrar = document.getElementById("close");
    
    
    
    btn_modal_expediente.addEventListener("click", ()=>{
        
        if(modal_expediente.style.display == 'block'){
            modal_expediente.style.display='none';
        } else{
            modal_expediente.style.display='block';
        }
    })

    btn_cerrar.addEventListener("click", ()=>{
        if(modal_expediente.style.display == 'block'){
            modal_expediente.style.display='none';
        } else{
            modal_expediente.style.display='block';
        }
    });

});