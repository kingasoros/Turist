import React from 'react';
import { StyleSheet, View, Button, Platform } from 'react-native';
import * as Linking from 'expo-linking';
import MapView, { Marker } from 'react-native-maps';
import MapViewDirections from 'react-native-maps-directions';

const MapScreen = () => {
  const origin = { latitude: 46.0989, longitude: 19.6676 }; // Szabadka
  const destination = { latitude: 46.1031, longitude: 19.7582 }; // Palics
  const GOOGLE_MAPS_APIKEY = 'AIzaSyDVSOhkMOeIE1WAx1ifwwpsuKEVCnyYk2Q';

  // Navigáció indítása Google Maps alkalmazásban
  const startNavigation = () => {
    const url = Platform.select({
      ios: `maps://app?saddr=${origin.latitude},${origin.longitude}&daddr=${destination.latitude},${destination.longitude}&directionsmode=driving`,
      android: `google.navigation:q=${destination.latitude},${destination.longitude}&mode=d`
    });

    Linking.openURL(url).catch(err => console.error('Hiba a Google Maps megnyitásakor:', err));
  };

  return (
    <View style={styles.container}>
      <MapView
        style={styles.map}
        initialRegion={{
          latitude: 46.1000,
          longitude: 19.7000,
          latitudeDelta: 0.05,
          longitudeDelta: 0.05,
        }}
      >
        <Marker coordinate={origin} title="Szabadka" />
        <Marker coordinate={destination} title="Palics" />
        <MapViewDirections
          origin={origin}
          destination={destination}
          apikey={GOOGLE_MAPS_APIKEY}
          strokeWidth={5}
          strokeColor="blue"
          mode="DRIVING"
        />
      </MapView>

      {/* Gomb a navigáció indítására */}
      <View style={styles.buttonContainer}>
        <Button title="Indítás Google Maps-ben" onPress={startNavigation} />
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  map: {
    width: '100%',
    height: '90%',
  },
  buttonContainer: {
    position: 'absolute',
    bottom: 20,
    left: 20,
    right: 20,
    backgroundColor: 'white',
    borderRadius: 10,
    padding: 10,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 4,
    elevation: 5,
  },
});

export default MapScreen;
