import React, { useState, useEffect } from 'react';
import { StyleSheet, View, Text, StatusBar, Image, ScrollView, ImageBackground } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import AsyncStorage from '@react-native-async-storage/async-storage';
import BottomNavBar from './components/BottomNavBar';
import LoginScreen from './screens/LoginScreen';
import AttractionsScreen from './screens/AttractionsScreen';
import Map from './screens/Map';
import ProfileScreen from './screens/ProfileScreen';
import ToursScreen from './screens/ToursScreen';
import BASE_URL from './screens/config';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { TouchableOpacity } from 'react-native';


const Stack = createStackNavigator();

export default function App() {
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  useEffect(() => {
    const checkLoginStatus = async () => {
      const token = await AsyncStorage.getItem('auth_token');
      if (token) {
        setIsLoggedIn(true);
      } else {
        setIsLoggedIn(false);
      }
    };

    checkLoginStatus();
  }, []);

  const HomeScreen = ({ navigation }) => {
    return (
      <ImageBackground
      source={{ uri: `${BASE_URL}/Turist_MobilApp/img/backgrnd.jpg` }} 
      style={styles.container}
      >
      <StatusBar style="auto" />

      <Image
        source={{ uri: `${BASE_URL}/Turist_MobilApp/img/home_page3.jpg` }} 
        style={styles.image}
      />
      
      <Text style={styles.overlayText}>
        Fedezd fel a természet szépségeit és válaszd ki a számodra tökéletes túraútvonalat.
      </Text>

      <View style={styles.featureContainer}>
        <TouchableOpacity style={styles.featureItem} onPress={() => navigation.navigate('Tours')}>
          <Image
            source={{ uri: `${BASE_URL}/Turist_MobilApp/img/home_page2.jpg` }} 
            style={styles.featureImage}
          />
          <Text style={styles.featureText}>Túrák</Text>
        </TouchableOpacity>

        <TouchableOpacity style={styles.featureItem} onPress={() => navigation.navigate('Attractions')}>
          <Image
            source={{ uri: `${BASE_URL}/Turist_MobilApp/img/home_page1.jpg` }} 
            style={styles.featureImage}
          />
          <Text style={styles.featureText}>Látványok</Text>
        </TouchableOpacity>

        <TouchableOpacity style={styles.featureItem} onPress={() => navigation.navigate('Map')}>
          <Image
            source={{ uri: `${BASE_URL}/Turist_MobilApp/img/home_page0.jpg` }}
            style={styles.featureImage}
          />
          <Text style={styles.featureText}>Térképek</Text>
        </TouchableOpacity>
      </View>
      <BottomNavBar navigation={navigation} />
    </ImageBackground>
    );
  };

  return (
    <NavigationContainer>
      <Stack.Navigator
        initialRouteName={isLoggedIn ? "Home" : "Login"}
      >
        <Stack.Screen name="Login">
          {(props) => <LoginScreen {...props} onLogin={() => setIsLoggedIn(true)} />}
        </Stack.Screen>
        <Stack.Screen 
          name="Home" 
          component={HomeScreen}
          options={{ headerLeft: null }}
        />
        <Stack.Screen name="Attractions" component={AttractionsScreen} />
        <Stack.Screen name="Map" component={Map} />
        <Stack.Screen name="Profile" component={ProfileScreen} />
        <Stack.Screen name="Tours" component={ToursScreen} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'flex-start', 
    alignItems: 'center',
  },
  image: {
    width: '100%',
    height: 200,
  },
  overlayText: {
    position: 'absolute',
    top: '8%',  
    left: '5%',
    right: '5%',
    fontSize: 18,
    fontWeight: 'bold',
    color: '#fff',
    textAlign: 'center',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',  
    padding: 10,
    borderRadius: 10,
  },
  featureContainer: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    width: '100%',
    marginTop: 150,
  },
  featureItem: {
    alignItems: 'center',
  },
  featureImage: {
    width: 100,
    height: 100,
    borderRadius: 50,
    marginBottom: 8,
  },
  featureText: {
    fontSize: 14,
    color: '#000',
    backgroundColor: '#fff',
    textAlign: 'center',
    padding: 5,
    borderRadius: 10,
  },
});
