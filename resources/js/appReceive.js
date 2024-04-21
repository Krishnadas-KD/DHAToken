import axios from 'axios';
import './bootstrap';



const channel=Echo.channel('token.display');

channel.subscribed(()=>{
    console.log('subscribed!');
}).listen('.display',(event)=>{
    console.log(event);
});