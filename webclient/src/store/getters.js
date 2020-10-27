export default {
	isAuthenticated: state => !!state.token,
	authStatus: state => state.status,
	getErrorMsg: state => state.errorMsg,
	isAdmin: state => state.admin,
	getToken: state => `Bearer_${state.token}`,
	getUsername: state => state.username,
	getProfile: state => state.profile,
	getContact: state => state.contact,
	getNews: state => id => state.news.find((el)=>el.id === id),
	getClaim: state => id => state.claims.find( el => el.id === id)
}