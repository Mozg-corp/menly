module.exports = {
  "devServer": {
    "proxy": {
      "/auth/sign-in": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/auth/sign-up": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/shops": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      // "/shop/:id": {
      //   "target": "http://localhost:8000",
      //     ws: true,
      //     changeOrigin: true
      // },
      "/chain": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/category/:id": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/racks/:id": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/find-path/:id": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/categories/:id": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/racks*": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/find-path*": {
        "target": "http://localhost:8000",
          ws: true,
          changeOrigin: true
      },
      "/maps": {
        "target": "http://localhost:8000/",
          ws: true,
          changeOrigin: true
      },
      "/posts": {
        "target": "http://localhost:8000/",
          ws: true,
          changeOrigin: true
      },
      "/posts/*": {
        "target": "http://localhost:8000/",
          ws: true,
          changeOrigin: true
      }
    }
  },
  "transpileDependencies": [
    "vuetify"
  ]
};