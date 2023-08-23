const rollupVue = require('rollup-plugin-vue2');
const babelMinify = require('rollup-plugin-babel-minify');

module.exports = {
	input: './src/main.js',
	output: '../script.js',
	namespace: 'BX.Polus.Components',
	plugins: {
		resolve: true,
		custom: [
			rollupVue(),
			babelMinify({
				comments: false,
			})
		]
	}
};