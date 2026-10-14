const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");

/**
 * Build aset TailAdmin (Tailwind v4 + Alpine) untuk project CodeIgniter 3.
 * Hasil build:
 *   assets/css/style.css
 *   assets/js/bundle.js
 *   assets/images/...
 *
 *   npm run build   -> produksi (minify)
 *   npm run watch   -> development, rebuild otomatis saat file berubah
 */
module.exports = (env, argv) => ({
  mode: argv.mode || "production",
  entry: "./src/js/index.js",
  devtool: argv.mode === "development" ? "source-map" : false,
  output: {
    filename: "js/bundle.js",
    path: path.resolve(__dirname, "assets"),
    clean: true,
  },
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: { presets: ["@babel/preset-env"] },
        },
      },
      {
        test: /\.css$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader", "postcss-loader"],
      },
      {
        test: /\.(png|svg|jpg|jpeg|gif)$/i,
        type: "asset/resource",
        generator: { filename: "media/[name][ext]" },
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/i,
        type: "asset/resource",
        generator: { filename: "fonts/[name][ext]" },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({ filename: "css/style.css" }),
    new CopyWebpackPlugin({
      patterns: [{ from: "src/images", to: "images" }],
    }),
  ],
  performance: { hints: false },
  target: "web",
});
