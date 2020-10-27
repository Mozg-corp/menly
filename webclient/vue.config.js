module.exports = {
  devServer: {
	https: true,
    proxy: {
      "^/api*": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "^/auth*": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      }
	}
  },
  "transpileDependencies": [
    "vuetify"
  ]
};