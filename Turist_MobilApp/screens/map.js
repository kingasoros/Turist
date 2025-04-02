import React from 'react';
import { StyleSheet, View, Button, Platform, Alert, Text } from 'react-native';
import * as Linking from 'expo-linking';
import MapView, { Marker } from 'react-native-maps';
import MapViewDirections from 'react-native-maps-directions';
import { useRoute } from '@react-navigation/native';

const GOOGLE_MAPS_APIKEY = 'AIzaSyDVSOhkMOeIE1WAx1ifwwpsuKEVCnyYk2Q';

const MapScreen = () => {
  const route = useRoute();
  const { coordinates } = route.params || { coordinates: [] }; // ✅ Helyes változónév

  console.log("Kapott koordináták:", coordinates);

  if (!coordinates.length) {
    return (
      <View style={styles.container}>
        <Text style={styles.errorText}>Nincsenek elérhető koordináták!</Text>
      </View>
    );
  }

  // Átalakítjuk a koordinátákat a megfelelő formátumba
  const formattedCoords = coordinates.map(coord => ({
    latitude: coord.coordinates.lat,
    longitude: coord.coordinates.lng
  }));

  const origin = formattedCoords.length > 0 ? formattedCoords[0] : null;
  const destination = formattedCoords.length > 1 ? formattedCoords[formattedCoords.length - 1] : null;

  const startNavigation = () => {
    if (!origin || !destination) {
      Alert.alert("Hiba", "Nincsenek megfelelő koordináták a navigációhoz.");
      return;
    }

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
          latitude: origin.latitude,
          longitude: origin.longitude,
          latitudeDelta: 0.05,
          longitudeDelta: 0.05,
        }}
      >
        {formattedCoords.map((coord, index) => (
          <Marker key={index} coordinate={coord} title={`Helyszín ${index + 1}`} />
        ))}

        {origin && destination && (
          <MapViewDirections
            origin={origin}
            destination={destination}
            waypoints={formattedCoords.length > 2 ? formattedCoords.slice(1, -1) : []}
            apikey={GOOGLE_MAPS_APIKEY}
            strokeWidth={5}
            strokeColor="blue"
            mode="DRIVING"
            onError={(error) => {
              console.error('Google Maps Directions hiba:', error);
              Alert.alert('Útvonalhiba', 'Nem található érvényes útvonal a kiválasztott pontok között.');
            }}
          />
        )}
      </MapView>

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
  errorText: {
    fontSize: 16,
    color: 'red',
    textAlign: 'center',
    marginTop: 20,
  },
});

export default MapScreen;
