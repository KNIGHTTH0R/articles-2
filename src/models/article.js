
export default {

  namespace: 'article',

  state: {
    total: 0,
    currentPage: 0,
    pageNum: 10,
    listType: 0, //0: 全文列表，1:摘要列表，2:搜索列表，3:用户文章列表
    list: [],
    currentArticle: {},
    keyword: ''
  },

  effects: {
    *fetchList() {},
    *fetchArticle() {},
    *addArticle() {},
    *updateArticle() {},
    *removeArticle() {},
  },

  reducers: {
    fetchListSuccess() {},
    fetchListField() {},
    fetchArticleSuccess() {},
    fetchArticleField() {},
    addArticleSuccess() {},
    addArticleField() {},
    updateArticleSuccess() {},
    updateArticleField() {},
    removeArticleSuccess() {},
    removeArticleField() {},
  },

};
