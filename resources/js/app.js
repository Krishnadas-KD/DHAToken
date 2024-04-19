import './bootstrap';


const channel=Echo.channel('token.display.socket');

channel.subscribed(()=>{
    console.log('subscribed!');
});