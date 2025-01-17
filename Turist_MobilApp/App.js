import React from 'react';
import { StatusBar } from 'expo-status-bar';
import { StyleSheet, Text, View } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

import BottomNavBar from './components/BottomNavBar'; 
import MapScreen from './screens/map';
import AttractionsScreen from './screens/AttractionsScreen';

const Stack = createStackNavigator();

export default function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home" screenOptions={{ headerStyle: {backgroundColor: '#fff', },cardStyle: {
      backgroundColor: '#f5f5f5', }}}>
        <Stack.Screen name="Home" component={HomeScreen} />
        <Stack.Screen name="Map" component={MapScreen} />
        <Stack.Screen name="Attractions" component={AttractionsScreen} />
      </Stack.Navigator>
</NavigationContainer>

  );
}

// Főoldal képernyő (HomeScreen)
const HomeScreen = ({ navigation }) => { 
  return (
    <View style={appStyles.container}>
      <Text>Open up App.js to start working on your app!</Text>
      <StatusBar style="auto" />
      <View style={appStyles.mainContent}>
        <Text>Main content goes here!</Text>
      </View>
      <BottomNavBar navigation={navigation} /> 
    </View>
  );
}

const appStyles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  mainContent: {
    flex: 1,
    justifyContent: 'center', 
    alignItems: 'center',
  },
});
