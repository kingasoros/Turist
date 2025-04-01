import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, Alert, FlatList, Image, TouchableOpacity } from 'react-native';
import BASE_URL from './config';

const ToursScreen = () => {
  const [tours, setTours] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`${BASE_URL}/Turist_MobilApp/screens/get_user_tours.php`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    })
      .then((response) => {
        if (response.status === 200) {
          return response.json();
        } else if (response.status === 401) {
          Alert.alert('Hiba', 'Kérlek jelentkezz be újra!');
          throw new Error('Unauthorized access');
        } else if (response.status === 404) {
          Alert.alert('Nincs kedvenc túra', 'Nem található túra az adatbázisban.');
          throw new Error('No tours found');
        } else if (response.status === 500) {
          Alert.alert('Hiba', 'Szerverhiba történt.');
          throw new Error('Server error');
        } else {
          throw new Error(`Unhandled status code: ${response.status}`);
        }
      })
      .then((data) => {
        if (data.success) {
          setTours(data.tours);
        }
      })
      .catch((error) => {
        console.error('Fetch Error:', error);
      })
      .finally(() => setLoading(false));    
  }, []);

  const startTour = (attractions) => {
    const addresses = attractions.map(attraction => attraction.address);

    console.log("Küldött JSON:", JSON.stringify({ addresses })); // Ellenőrzésre

    fetch(`${BASE_URL}/Turist_MobilApp/screens/Map.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ addresses }),
    })
    .then(response => response.text()) // Váltás text módra
    .then(text => {
      console.log("Szerver válasz:", text);
      return JSON.parse(text); // Kézi JSON parse, ha esetleg formátumhiba van
    })
    .then(data => {
      if (data.success) {
        Alert.alert('Siker', 'Az útvonal sikeresen elküldve.');
      } else {
        Alert.alert('Hiba', data.message || 'Ismeretlen hiba történt.');
      }
    })
    .catch(error => {
      console.error('Hálózati hiba:', error);
      Alert.alert('Hálózati hiba', error.message);
    });

  };

  const renderAttractions = (attractions) => {
    if (attractions && attractions.length > 0) {
      return attractions.map((attraction, index) => (
        <View key={index} style={styles.attractionCard}>
          <Text style={styles.attractionText}>Város: {attraction.city_name || 'Nincs város'}</Text>
          <Text style={styles.attractionText}>Név: {attraction.name || 'Nincs név'}</Text>
          <Text style={styles.attractionText}>Leírás: {attraction.description || 'Nincs leírás'}</Text>
          <Text style={styles.attractionText}>Cím: {attraction.address || 'Nincs cím'}</Text>
          <Image source={{ uri: attraction.image }} style={styles.image} />
        </View>
      ));
    }
    return <Text style={styles.attractionText}>Nincs attrakció</Text>;
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Kedvenc Túrák</Text>
      {loading ? (
        <Text style={styles.loadingText}>Betöltés...</Text>
      ) : (
        <FlatList
          data={tours}
          keyExtractor={(item) => item.tour_id.toString()}
          renderItem={({ item }) => (
            <View style={styles.tourCard}>
              <Text style={styles.tourName}>{item.tour_name}</Text>
              <Text style={styles.tourDescription}>{item.tour_description}</Text>
              <Text style={styles.startDate}>{item.start_date} - {item.end_date}</Text>
              <Text style={styles.tourPrice}>Ár: {item.price} HUF</Text>
              <View style={styles.attrContainer}>{renderAttractions(item.attractions)}</View>
              <TouchableOpacity style={styles.startButton} onPress={() => startTour(item.attractions)}>
                <Text style={styles.buttonText}>Indítás</Text>
              </TouchableOpacity>
            </View>
          )}
        />
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#3b5147',
    padding: 16,
  },
  tourCard: {
    backgroundColor: '#f9f9f9',
    padding: 16,
    marginBottom: 10,
    borderRadius: 8,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  tourName: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#3b5147',
  },
  attractionCard: {
    marginBottom: 10,
    padding: 8,
    backgroundColor: '#9f9f9f',
    borderRadius: 5,
  },
  attractionText: {
    fontSize: 14,
    color: '#000',
  },
  startButton: {
    marginTop: 10,
    backgroundColor: '#007bff',
    padding: 10,
    borderRadius: 5,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default ToursScreen;
