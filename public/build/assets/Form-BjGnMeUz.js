import{k as g,C as S,Q as D,m as F,D as f,f as n,a as b,u as o,w as h,F as M,o as r,Z as N,b as s,i as u,A as c,t as v,g as y,S as x}from"./app-929ikU7m.js";import{_ as T}from"./AuthenticatedLayout-wQM5iXEG.js";import{d as U}from"./index-3ddl9PSD.js";import"./ApplicationLogo-CG5iv4N8.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const j={class:"text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"},A={key:0},R={key:1},B={class:"devices__create"},$={class:"devices__create__cardWrapper mt-2"},W={class:"devices__create__main"},L={class:"devices__create__main--addInfo card py-2 px-2 bg-white"},O={key:0,style:{color:"red"}},P={key:1,style:{color:"red"}},Q={key:2,style:{color:"red"}},Z={class:"devices__create__main--media--images mt-2"},q={class:"devices__create__main--media--images--list list-unstyled"},z={class:"devices__create__main--media--images--item"},G={class:"devices__create__main--media--images--item--imgWrapper"},H=["src"],J={class:"devices__create__main--media--images--item"},K={class:"devices__create__main--media--images--item--form"},le={__name:"Form",setup(X){const d=g(),a=S({image:"",name:"",email:"",phone:"",role:""}),_=D(),p=g(!1);let l=g([]);F(()=>{_.props.route&&_.props.route.name==="users.edit"&&(p.value=!0,d.value=_.props.route.params.id,console.log("Edit Mode, User ID:",d.value),k())});const k=async()=>{try{let i=await f.get(`/api/users/${d.value}/edit`);console.log("API Response for User:",i.data),i.data.user&&(a.image=i.data.user.image,a.name=i.data.user.name,a.email=i.data.user.email,a.phone=i.data.user.phone,a.role=i.data.user.role)}catch(i){console.error("Error fetching user data:",i)}},w=()=>{let i="/upload/no-image.jpg";return a.image&&(a.image.indexOf("base64")!=-1?i=a.image:i="/upload/"+a.image),i},I=i=>{const e=i.target;let t=e.files?e.files[0]:null;if(t){const m=new FileReader;m.onloadend=Y=>{m.result&&(a.image=m.result)},m.readAsDataURL(t)}},V=(i,e)=>{p.value?E():C()},C=(i,e)=>{f.post("/api/users",a).then(t=>{x.fire({icon:"success",title:"utilisateur ajouté"}),setTimeout(()=>{U.Inertia.visit("/users/index/")},2e3)}).catch(t=>{t.response&&t.response.status===422?l.value=t.response.data.errors:console.error("Error creating user:",t)})},E=(i,e)=>{f.put(`/api/users/${d.value}`,a).then(t=>{x.fire({icon:"success",title:"Type d'utilisateur modifié"}),setTimeout(()=>{U.Inertia.visit("/users/index/")},2e3)}).catch(t=>{t.response.status===422?l.value=t.response.data.errors:console.error("Error creating user:",t)})};return(i,e)=>(r(),n(M,null,[b(o(N),{title:"Enregistrement d'un utilisateur"}),b(T,null,{header:h(()=>[s("h2",j,[p.value?(r(),n("span",A,"Modification d'un utilisateur")):(r(),n("span",R,"Nouvel Utilisateur"))])]),default:h(()=>[s("div",B,[e[10]||(e[10]=s("div",{class:"devices__create__titlebar dflex justify-content-between align-items-center"},[s("div",{class:"devices__create__titlebar--item"},[s("button",{class:"btn btn-secondary ml-1"},"Save")])],-1)),s("div",$,[s("div",W,[s("div",L,[e[5]||(e[5]=s("p",{class:"mb-1"},"Nom",-1)),u(s("input",{type:"text",class:"input",id:"name",name:"name","onUpdate:modelValue":e[0]||(e[0]=t=>a.name=t)},null,512),[[c,a.name]]),o(l).name?(r(),n("small",O,v(o(l).name),1)):y("",!0),e[6]||(e[6]=s("p",{class:"mb-1"},"e-mail",-1)),u(s("input",{type:"text",class:"input",id:"email",name:"email","onUpdate:modelValue":e[1]||(e[1]=t=>a.email=t)},null,512),[[c,a.email]]),o(l).email?(r(),n("small",P,v(o(l).email),1)):y("",!0),e[7]||(e[7]=s("p",{class:"mb-1"},"Téléphone",-1)),u(s("input",{type:"text",class:"input",id:"phone",name:"phone","onUpdate:modelValue":e[2]||(e[2]=t=>a.phone=t)},null,512),[[c,a.phone]]),e[8]||(e[8]=s("p",{class:"mb-1"},"Rôle",-1)),u(s("input",{type:"text",class:"input",id:"role",name:"role","onUpdate:modelValue":e[3]||(e[3]=t=>a.role=t)},null,512),[[c,a.role]]),o(l).role?(r(),n("small",Q,v(o(l).role),1)):y("",!0),s("div",Z,[s("ul",q,[s("li",z,[s("div",G,[s("img",{src:w(),class:"devices__create__main--media--images--item--img",alt:""},null,8,H)])]),s("li",J,[s("form",K,[e[4]||(e[4]=s("label",{class:"devices__create__main--media--images--item--form--label",for:"myfile"},"Add Image",-1)),s("input",{class:"devices__create__main--media--images--item--form--input",type:"file",id:"myfile",onChange:I},null,32)])])])])])])]),s("div",{class:"dflex justify-content-between align-items-center my-3"},[e[9]||(e[9]=s("p",null,null,-1)),s("button",{class:"btn btn-secondary",onClick:V},"Save")])])]),_:1})],64))}};export{le as default};
