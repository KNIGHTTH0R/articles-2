
export default {

  namespace: 'user',

  state: {
    username: '',
    email: '',
    firstTime: '',
    isLogined: false
  },

  effects: {
    *signup() {},
    *login() {},
    *changepass() {},
    *changeemail() {},
    *logout() {},
  },

  reducers: {
    signupSuccess() {},
    signupField() {},
    loginSuccess() {},
    loginField() {},
    changepassSuccess() {},
    changepassField() {},
    changeemailSuccess() {},
    changeemailField() {},
    logoutSuccess() {},
  },

};
