export default{
	userId: '',
	token: '',
	status: '',
	errorMsg: '',
	admin: false,
	username: '',
	agregators_list: [],
	user: {},
	users: [],
	balances: [],
	userStatuses: [
		'Not Active',
		'Candidate',
		'User'
	],
	transactions: [],
	transfers: [],
	allTransfers: [],
	loadingUserData: false,
	loadingBalances: false,
	userHasCarData: localStorage.getItem('userHasCarData')||null,
	userHasProfileData: localStorage.getItem('userHasProfileData')||null,
	userChooseAgregator: localStorage.getItem('userChooseAgregator')||null
}