import React, { useState, useEffect } from 'react';
import { StyleSheet, View, Button, Platform, Alert, Text, ActivityIndicator } from 'react-native';
import * as Location from 'expo-location';
import * as Linking from 'expo-linking';
import MapView, { Marker } from 'react-native-maps';
import MapViewDirections from 'react-native-maps-directions';
import { useRoute } from '@react-navigation/native';

const GOOGLE_MAPS_APIKEY = 'AIzaSyDVSOhkMOeIE1WAx1ifwwpsuKEVCnyYk2Q';

const MapScreen = () => {
  const route = useRoute();
  const { coordinates } = route.params || { coordinates: [] };
  
  const [currentLocation, setCurrentLocation] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    (async () => {
      let { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        Alert.alert('Hozzáférési hiba', 'Engedély szükséges a helymeghatározáshoz.');
        setLoading(false);
        return;
      }

      let location = await Location.getCurrentPositionAsync({});
      setCurrentLocation({
        latitude: location.coords.latitude,
        longitude: location.coords.longitude,
      });

      setLoading(false);
    })();
  }, []);

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#0000ff" />
        <Text>Helyzet betöltése...</Text>
      </View>
    );
  }

  if (!currentLocation) {
    return (
      <View style={styles.container}>
        <Text style={styles.errorText}>Nem sikerült betölteni az aktuális helyzetet.</Text>
      </View>
    );
  }

  const formattedCoords = coordinates.map(coord => ({
    latitude: coord.coordinates.lat,
    longitude: coord.coordinates.lng
  }));

  const allPoints = [currentLocation, ...formattedCoords];

  const startNavigation = () => {
    if (allPoints.length < 2) {
      Alert.alert("Hiba", "Nincsenek megfelelő pontok a navigációhoz.");
      return;
    }

    const url = Platform.select({
      ios: `maps://app?saddr=${allPoints[0].latitude},${allPoints[0].longitude}&daddr=${allPoints[1].latitude},${allPoints[1].longitude}&directionsmode=driving`,
      android: `google.navigation:q=${allPoints[1].latitude},${allPoints[1].longitude}&mode=d`
    });

    Linking.openURL(url).catch(err => console.error('Hiba a Google Maps megnyitásakor:', err));
  };

  return (
    <View style={styles.container}>
      <MapView
        style={styles.map}
        initialRegion={{
          latitude: currentLocation.latitude,
          longitude: currentLocation.longitude,
          latitudeDelta: 0.05,
          longitudeDelta: 0.05,
        }}
      >
        {allPoints.map((coord, index) => (
          <Marker 
            key={index} 
            coordinate={coord} 
            title={index === 0 ? "Jelenlegi helyzet" : `Helyszín ${index}`} 
          />
        ))}

        {allPoints.length > 1 && (
          <MapViewDirections
            origin={allPoints[0]}
            destination={allPoints[allPoints.length - 1]}
            waypoints={allPoints.length > 2 ? allPoints.slice(1, -1) : []}
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
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default MapScreen;
