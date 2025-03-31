import React, { useEffect, useState } from 'react';
import { View, StyleSheet, Text, ActivityIndicator, Button } from 'react-native';
import MapView, { Marker } from 'react-native-maps';
import MapViewDirections from 'react-native-maps-directions';
import * as Location from 'expo-location';

const GOOGLE_MAPS_APIKEY = 'AIzaSyDVSOhkMOeIE1WAx1ifwwpsuKEVCnyYk2Q';

const Map = () => {
  const [location, setLocation] = useState(null);
  const [errorMsg, setErrorMsg] = useState(null);
  const [tracking, setTracking] = useState(false); // Kezdetben nincs követés
  const [region, setRegion] = useState(null); // A térkép aktuális régiója

  const destination = {
    latitude: 46.2496,
    longitude: 20.1071,
  };

  useEffect(() => {
    (async () => {
      let { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        setErrorMsg('Hozzáférés megtagadva a helyadatokhoz.');
        return;
      }

      let location = await Location.getCurrentPositionAsync({});
      setLocation({
        latitude: location.coords.latitude,
        longitude: location.coords.longitude,
      });

      // Hely folyamatos frissítése
      Location.watchPositionAsync(
        { accuracy: Location.Accuracy.High, timeInterval: 1000, distanceInterval: 1 },
        (newLocation) => {
          setLocation({
            latitude: newLocation.coords.latitude,
            longitude: newLocation.coords.longitude,
          });
        }
      );
    })();
  }, []);

  if (!location) {
    return (
      <View style={styles.loading}>
        <ActivityIndicator size="large" color="#0000ff" />
        <Text style={{ marginTop: 10 }}>Helyzet meghatározása...</Text>
      </View>
    );
  }

  const handleStartTracking = () => {
    setTracking(true);
    setRegion({
      latitude: location.latitude,
      longitude: location.longitude,
      latitudeDelta: 0.05, // Nagyobb nagyítás, amikor követi a helyzetet
      longitudeDelta: 0.05,
    });
  };

  const handleStopTracking = () => {
    setTracking(false);
    setRegion({
      latitude: location.latitude,
      longitude: location.longitude,
      latitudeDelta: 0.1, // Normál nézet
      longitudeDelta: 0.1,
    });
  };

  return (
    <>
      <MapView
        style={styles.map}
        region={region || { latitude: location.latitude, longitude: location.longitude, latitudeDelta: 0.1, longitudeDelta: 0.1 }}
        showsUserLocation={true} // Aktuális helyzet megjelenítése
        followUserLocation={tracking} // Követi a helyzetet, ha a tracking be van kapcsolva
        showsMyLocationButton={true} // Helymeghatározás gomb
      >
        <Marker coordinate={location} title="Te" />
        <Marker coordinate={destination} title="Cél: Horgosi út 136" />

        <MapViewDirections
          origin={location}
          destination={destination}
          apikey={GOOGLE_MAPS_APIKEY}
          strokeWidth={4}
          strokeColor="blue"
        />
      </MapView>

      {/* Gomb a követés be- és kikapcsolásához */}
      <Button
        title={tracking ? "Követés kikapcsolása" : "Követés bekapcsolása"}
        onPress={tracking ? handleStopTracking : handleStartTracking}
      />
    </>
  );
};

const styles = StyleSheet.create({
  map: {
    flex: 1,
  },
  loading: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default Map;
