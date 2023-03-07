/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function CheckPassword(password_confirmation){
    var input1 = password.value;
    var input1 = passConfirm.value;
    
    if(input1 != input2){
        passConfirm.setCustomValidity('パスワードが一致しません');
    }else{
        passConfirm.setCustomValidity('');
    }
};