import React from 'react'; 
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native'; 
import { Ionicons } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';

const BottomNavBar = ({ navigation }) => { 
 
  return (
    <View style={topNavBarStyles.container}>
      <View style={topNavBarStyles.iconsContainer}>
        <TouchableOpacity style={topNavBarStyles.button}
        onPress={() => navigation.navigate('Attractions')}>
          <Ionicons name="search" size={30} />
        </TouchableOpacity>
        <TouchableOpacity style={topNavBarStyles.button}>
          <Ionicons name="heart" size={30} />
        </TouchableOpacity>
        <TouchableOpacity style={topNavBarStyles.button}>
          <Ionicons name="home" size={45} />
        </TouchableOpacity>
        <TouchableOpacity 
          style={topNavBarStyles.button} 
          onPress={() => navigation.navigate('Map')} 
        >
          <Ionicons name="map" size={30} />
        </TouchableOpacity>
        <TouchableOpacity style={topNavBarStyles.button}>
          <Ionicons name="person" size={30} />
        </TouchableOpacity>
      </View>
    </View>
  );
};

const topNavBarStyles = StyleSheet.create({
  container: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    height:100, 
    backgroundColor: '#3b5147',
    paddingHorizontal: 10,
    borderBottomColor: '#ddd',
  },
  iconsContainer: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    alignItems: 'center',
    flex: 1, 
  },
  button: {
    alignItems: 'center',
    justifyContent: 'center',
    color:"#000",
  },
});

export default BottomNavBar;
