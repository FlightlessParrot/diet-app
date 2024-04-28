import{T as p,o as c,c as f,w as n,a as e,b as a,u as o,d as _,e as v}from"./app-CPbxQ4uM.js";import{_ as r,a as d,b as i}from"./TextInput-D6RXzK5j.js";import{T as y}from"./Tile-BrZLmnEW.js";import{_ as V}from"./AuthenticatedLayout-C7a6ZqBo.js";import{P as g}from"./PrimaryButton-CxDoy11j.js";import{_ as w}from"./PrimeDropdown-BKox0XK1.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ApplicationLogo-BvMeX-pz.js";import"./index.esm-DmIHt39k.js";import"./ripple.esm-CUpsdt_m.js";import"./portal.esm-FhGMjhHZ.js";const x=a("header",null,[a("h2",{class:"text-lg font-medium text-gray-900"},"Podaj adres"),a("p",{class:"mt-1 text-sm text-gray-600"}," Podaj adres, pod którym znajdą Cię Twoi klienci. ")],-1),b={class:"grid grid-cols-2 gap-4"},N={__name:"CreateSpecialistAddress",props:{provinces:{type:Array,required:!0}},setup(u){const l=p({province_id:null,city:"",code:"",line_1:"",line_2:""});return(m,s)=>(c(),f(V,null,{default:n(()=>[e(y,null,{default:n(()=>[x,a("form",{onSubmit:s[5]||(s[5]=v(t=>o(l).post(m.route("specialist.address.create"),{preserveScroll:!0}),["prevent"])),class:"mt-6 space-y-6"},[a("div",null,[e(r,{for:"line_1",value:"Adres - pierwsza linia"}),e(d,{id:"line_1",type:"text",class:"mt-1 block w-full",modelValue:o(l).line_1,"onUpdate:modelValue":s[0]||(s[0]=t=>o(l).line_1=t),autofocus:""},null,8,["modelValue"]),e(i,{class:"mt-2",message:o(l).errors.line_1},null,8,["message"])]),a("div",null,[e(r,{for:"line_2",value:"Adres - druga linia"}),e(d,{id:"line_2",type:"text",class:"mt-1 block w-full",modelValue:o(l).line_2,"onUpdate:modelValue":s[1]||(s[1]=t=>o(l).line_2=t),autofocus:""},null,8,["modelValue"]),e(i,{class:"mt-2",message:o(l).errors.line_2},null,8,["message"])]),a("div",null,[e(r,{for:"province",value:"Województwo"}),e(w,{modelValue:o(l).province_id,"onUpdate:modelValue":s[2]||(s[2]=t=>o(l).province_id=t),required:"",placeholder:"Wybierz województwo",options:u.provinces},null,8,["modelValue","options"]),e(i,{class:"mt-2",message:o(l).errors.province},null,8,["message"])]),a("div",b,[a("div",null,[e(r,{for:"city",value:"Miasto"}),e(d,{id:"city",type:"text",class:"mt-1 inline-block w-full",modelValue:o(l).city,"onUpdate:modelValue":s[3]||(s[3]=t=>o(l).city=t),required:"",autofocus:""},null,8,["modelValue"]),e(i,{class:"mt-2",message:o(l).errors.city},null,8,["message"])]),a("div",null,[e(r,{for:"code",value:"Kod pocztowy"}),e(d,{id:"code",type:"text",class:"mt-1 inline-block w-full",modelValue:o(l).code,"onUpdate:modelValue":s[4]||(s[4]=t=>o(l).code=t),required:"",autofocus:""},null,8,["modelValue"]),e(i,{class:"mt-2",message:o(l).errors.code},null,8,["message"])])]),e(g,null,{default:n(()=>[_(" Dalej ")]),_:1})],32)]),_:1})]),_:1}))}};export{N as default};