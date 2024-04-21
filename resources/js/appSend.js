import axios from 'axios';
import './bootstrap';

var count=1;
const click=document.getElementById('clickme');
click.addEventListener('click',function (e){
    count=count+1;

    axios.post('/clicked-button',{
        message:count
    });
});


