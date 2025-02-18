import{h as w,i as y,v as b,o as n,f as d,T as x,c as f,w as c,a as o,u as s,Z as V,t as g,g as u,b as l,j as S,d as B,n as $,e as C}from"./app-Dkm1rt9V.js";import{_ as N}from"./GuestLayout-BB7ZST-E.js";import{_ as k,a as _,b as h}from"./TextInput-DVBN9syc.js";import{P}from"./PrimaryButton-CFSYnoOk.js";import"./ApplicationLogo-mZEy1bWB.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const q=["value"],U={__name:"Checkbox",props:{checked:{type:[Array,Boolean],required:!0},value:{default:null}},emits:["update:checked"],setup(i,{emit:e}){const m=e,r=i,t=w({get(){return r.checked},set(a){m("update:checked",a)}});return(a,p)=>y((n(),d("input",{type:"checkbox",value:i.value,"onUpdate:modelValue":p[0]||(p[0]=v=>t.value=v),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,q)),[[b,t.value]])}},z={key:0,class:"mb-4 text-sm font-medium text-green-600"},A={class:"mt-4"},E={key:0,class:"mt-4 text-red-600"},M={class:"mt-4 block"},T={class:"flex items-center"},j={class:"mt-4 flex items-center justify-end"},D={key:0},I={key:1},J={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(i){const e=x({email:"",password:"",remember:!1}),m=()=>{e.post(route("login"),{onSuccess:r=>{r.props.token?(localStorage.setItem("Authorization",`Bearer ${r.props.token}`),console.log("Token stored in localStorage:",localStorage.getItem("Authorization"))):console.error("No token received from the server."),r.props.redirect_route&&(window.location.href=r.props.redirect_route)},onFinish:()=>e.reset("password")})};return(r,t)=>(n(),f(N,null,{default:c(()=>[o(s(V),{title:"Log in"}),i.status?(n(),d("div",z,g(i.status),1)):u("",!0),l("form",{onSubmit:C(m,["prevent"])},[l("div",null,[o(k,{for:"email",value:"Email"}),o(_,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=a=>s(e).email=a),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(h,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),l("div",A,[o(k,{for:"password",value:"Password"}),o(_,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=a=>s(e).password=a),required:"",autocomplete:"current-password"},null,8,["modelValue"]),o(h,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),s(e).errors.message?(n(),d("div",E,g(s(e).errors.message),1)):u("",!0),l("div",M,[l("label",T,[o(U,{name:"remember",checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=a=>s(e).remember=a)},null,8,["checked"]),t[3]||(t[3]=l("span",{class:"ms-2 text-sm text-gray-600"},"Se souvenir de moi",-1))])]),l("div",j,[i.canResetPassword?(n(),f(s(S),{key:0,href:r.route("password.request"),class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"},{default:c(()=>t[4]||(t[4]=[B(" Mot de passe oublié? ")])),_:1},8,["href"])):u("",!0),o(P,{class:$(["ms-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:c(()=>[s(e).processing?(n(),d("span",D,"En cours de connection...")):(n(),d("span",I,"Se connecter"))]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{J as default};
