module.exports = function (api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo'],
    plugins: [
      [
        'module:react-native-dotenv',
        {
          moduleName: '@env',  // A kívánt modul név
          path: '.env',  // Az env fájl helye
        },
      ],
    ],
  };
};
