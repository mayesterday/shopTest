(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-912f0a9e"],{"03d1":function(e,a,t){"use strict";t.r(a);var n=function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("layout-vertical",[t("router-view")],1)},r=[],o=function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",{staticClass:"vertical-layout h-100",class:[e.layoutClasses],attrs:{"data-col":e.isNavMenuHidden?"1-column":null}},[t("b-navbar",{staticClass:"header-navbar navbar navbar-shadow align-items-center",class:[e.navbarTypeClass],attrs:{toggleable:!1,variant:e.navbarBackgroundColor}},[e._t("navbar",[t("app-navbar-vertical-layout",{attrs:{"toggle-vertical-menu-active":e.toggleVerticalMenuActive}})],{toggleVerticalMenuActive:e.toggleVerticalMenuActive,navbarBackgroundColor:e.navbarBackgroundColor,navbarTypeClass:e.navbarTypeClass.concat(["header-navbar navbar navbar-shadow align-items-center"])})],2),e.isNavMenuHidden?e._e():t("vertical-nav-menu",{attrs:{"is-vertical-menu-active":e.isVerticalMenuActive,"toggle-vertical-menu-active":e.toggleVerticalMenuActive},scopedSlots:e._u([{key:"header",fn:function(a){return[e._t("vertical-menu-header",null,null,a)]}}],null,!0)}),t("div",{staticClass:"sidenav-overlay",class:e.overlayClasses,on:{click:function(a){e.isVerticalMenuActive=!1}}}),t("transition",{attrs:{name:e.routerTransition,mode:"out-in"}},[t(e.layoutContentRenderer,{key:"layout-content-renderer-left"===e.layoutContentRenderer?e.$route.meta.navActiveLink||e.$route.name:null,tag:"component",scopedSlots:e._u([e._l(e.$scopedSlots,(function(a,t){return{key:t,fn:function(a){return[e._t(t,null,null,a)]}}}))],null,!0)})],1),t("footer",{staticClass:"footer footer-light",class:[e.footerTypeClass]},[e._t("footer",[t("app-footer")])],2),e._t("customizer")],2)},l=[],i=t("a6f4"),s=function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",{staticClass:"navbar-container d-flex content align-items-center"},[t("ul",{staticClass:"nav navbar-nav d-xl-none"},[t("li",{staticClass:"nav-item"},[t("b-link",{staticClass:"nav-link",on:{click:e.toggleVerticalMenuActive}},[t("feather-icon",{attrs:{icon:"MenuIcon",size:"21"}})],1)],1)]),t("div",{staticClass:"bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex"},[t("bookmarks")],1),t("b-navbar-nav",{staticClass:"nav align-items-center ml-auto"},[t("locale"),t("dark-Toggler",{staticClass:"d-none d-lg-block"}),t("search-bar"),t("cart-dropdown"),t("notification-dropdown"),t("user-dropdown")],1)],1)},c=[],u=t("aa59"),v=t("042b"),d=t("6957"),f=t("e2f5"),p=t("809a"),b=t("9f5c"),g=t("8a2e"),C=t("5c02"),y=t("eef9"),m={components:{BLink:u["a"],BNavbarNav:v["a"],Bookmarks:d["a"],Locale:f["a"],SearchBar:p["a"],DarkToggler:b["a"],CartDropdown:g["a"],NotificationDropdown:C["a"],UserDropdown:y["a"]},props:{toggleVerticalMenuActive:{type:Function,default:function(){}}}},k=m,h=t("2877"),w=Object(h["a"])(k,s,c,!1,null,null,null),M=w.exports,V=t("62cb"),A=t("b8f2"),T=t("d0b9"),_=t("1ae3"),L=t("e08f"),B=t("0d19"),N=t("2c28"),x=t("32b8"),$=t("1dff"),z={watch:{$route:function(){this.$store.state.app.windowWidth<$["a"].xl&&(this.isVerticalMenuActive=!1)}}},R={components:{AppNavbarVerticalLayout:M,AppFooter:V["a"],VerticalNavMenu:N["a"],BNavbar:T["a"],LayoutContentRendererLeftDetached:B["a"],LayoutContentRendererLeft:L["a"],LayoutContentRendererDefault:_["a"]},mixins:[z],computed:{layoutContentRenderer:function(){var e=this.$route.meta.contentRenderer;return"sidebar-left"===e?"layout-content-renderer-left":"sidebar-left-detached"===e?"layout-content-renderer-left-detached":"layout-content-renderer-default"}},setup:function(){var e=Object(A["a"])(),a=e.routerTransition,t=e.navbarBackgroundColor,n=e.navbarType,r=e.footerType,o=e.isNavMenuHidden,l=Object(x["a"])(n,r),s=l.isVerticalMenuActive,c=l.toggleVerticalMenuActive,u=l.isVerticalMenuCollapsed,v=l.layoutClasses,d=l.overlayClasses,f=l.resizeHandler,p=l.navbarTypeClass,b=l.footerTypeClass;return f(),window.addEventListener("resize",f),Object(i["onUnmounted"])((function(){window.removeEventListener("resize",f)})),{isVerticalMenuActive:s,toggleVerticalMenuActive:c,isVerticalMenuCollapsed:u,overlayClasses:d,layoutClasses:v,navbarTypeClass:p,footerTypeClass:b,routerTransition:a,navbarBackgroundColor:t,isNavMenuHidden:o}}},j=R,D=(t("15ae"),Object(h["a"])(j,o,l,!1,null,null,null)),O=D.exports,E=t("4778"),H={components:{AppCustomizer:E["a"],LayoutVertical:O},data:function(){return{showCustomizer:$["c"].layout.customizer}}},S=H,F=Object(h["a"])(S,n,r,!1,null,null,null);a["default"]=F.exports},"15ae":function(e,a,t){"use strict";t("9427")},9427:function(e,a,t){}}]);
//# sourceMappingURL=chunk-912f0a9e.082b6a38.js.map