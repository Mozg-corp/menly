import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index';

Vue.use(VueRouter);

const ifNotAuthenticated = (to, from, next) => {
    if (store.getters.isAuthenticated === true) {
        next();
		return;
    }
    next('/');
};

const ifNotAdmin = (to, from, next) => {
	if (store.getters.isAdmin === true) {
        next();
		return
    }
    next('/');
};

const routes = [
    {
        path: '/',
        name: 'home',
        component: ()=>import(/*webpackChunkName: "Home page"*/ '@/views/Home')
    },
    {
        path: '/profile',
        name:'profile',
        component: ()=>import(/*webpackChunkName: "Profile page"*/ '@/views/Profile'),
		beforeEnter: ifNotAuthenticated,
		children: [
			{
				path: 'personal',
				name: "personal", 
				component: ()=>import(/*webpackChunkName: "Profile Personal"*/ '@/components/Personal')
			},
			{
				path: 'counter',
				name: 'counter',
				component: ()=>import(/*webpackChunkName: "Profile Counter"*/ '@/components/Counter')
			},
			{
				path: 'claims',
				name: 'claims',
				component: ()=>import(/*webpackChunkName: "Profile Claims"*/ '@/components/Claims')
			},
			{
				path: 'claims/:id',
				name: 'single claim',
				props: true,
				component: ()=>import(/*webpackChunkName: "Profile Claims"*/ '@/components/ClaimSingle')
			},
			{
				path: 'createClaim',
				name: 'CreateClaim',
				component: ()=>import(/*webpackChunkName: 'Create Claim'*/ '@/components/ClaimCreate.vue')
			}
		]
    },
    {
        path: '/about',
        name:'about',
        component: ()=>import(/*webpackChunkName: "About page"*/ '@/views/About.vue'),
    },
    {
        path: '/contacts',
        name:'contacts',
        component: ()=>import(/*webpackChunkName: 'Contacts Page'*/ '@/views/Contacts.vue')
    },
	{
		path: '/admin',
		name: 'adminka',
		component: ()=>import(/*webpackChunkName: 'Adminka page'*/ '@/views/Admin.vue'),
		beforeEnter: ifNotAdmin,
		children: [
			{
				path: 'cityzens',
				name: 'cityzens',
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: 'Cityzens Page'*/ '@/components/Cityzens.vue')
			},
			{
				path: 'personal/:id',
				name: 'cityzen profile',
				props: true,
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: 'cityzen profile'*/ '@/components/PersonalAdmin.vue')
			},
			{
				path: 'meters',
				name: 'meters list',
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: 'all meters list'*/ '@/components/MetersList.vue')
			},
			{
				path: 'meters/:id',
				name: 'meters single',
				props: true,
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: 'single meter'*/ '@/components/MeterSingle.vue')
			},
			{
				path: 'payments',
				name: 'payments list',
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: 'all meters list'*/ '@/components/Payments.vue')
			},
			{
				path: 'claims',
				name: 'claims list',
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: 'all meters list'*/ '@/components/ClaimsAdmin.vue')
			},
			{
				path: 'claims/:id',
				name: 'single claim admin',
				props: true,
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: "Profile Claims"*/ '@/components/ClaimSingleAdmin')
			},
			{
				path: 'votes',
				name: 'votes list',
				beforeEnter: ifNotAdmin,
				component: ()=>import(/*webpackChunkName: "Profile Claims"*/ '@/components/VotesList')
			}
		]
	}
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

export default router
