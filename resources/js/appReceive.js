import axios from 'axios';
import './bootstrap';




var parts = window.location.href.split('/');
var index = parts.indexOf('display-route');

var service = parts[index + 1];
var section = parts[index + 2];


console.log(service);console.log(section);

var channel=Echo.channel('token.display');
if(service==="Registration" && section==="MALE") { console.log(service);console.log(section); channel=Echo.channel('token.display.male.registration'); }
if(service==="Blood%20Collection" && section==="MALE") { console.log(service);console.log(section); channel=Echo.channel('token.display.male.blood'); }
if(service==="X-Ray" && section==="MALE") { console.log(service);console.log(section); channel=Echo.channel('token.display.male.xray'); }


if(service==="Registration" && section==="FEMALE") { console.log(service);console.log(section); channel=Echo.channel('token.display.female.registration'); }
if(service==="Blood%20Collection" && section==="FEMALE") { console.log(service);console.log(section); channel=Echo.channel('token.display.female.blood'); }
if(service==="X-Ray" && section==="FEMALE") { console.log(service);console.log(section); channel=Echo.channel('token.display.female.xray'); }

channel.subscribed(()=>{
    console.log('subscribed!');
}).listen('.display',(event)=>{
    console.log(event);
});
