import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, FlatList, TextInput, Button, Image } from 'react-native';
import axios from 'axios';
import BASE_URL from './config';

const AttractionsScreen = () => {
  const [attractions, setAttractions] = useState([]);
  const [search, setSearch] = useState(''); 

  const fetchAttractions = (searchQuery) => {
    console.log('API hívás indítása', searchQuery); 
    axios
      .get(`${BASE_URL}/Turist_MobilApp/screens/get_attractions.php?search=${searchQuery}`)
      .then((response) => {
        if (response.status === 200) { // Ellenőrizzük, hogy sikeres-e a válasz
          setAttractions(response.data);
        } else {
          console.warn(`Nem sikeres válasz: ${response.status}`);
        }
      })
      .catch((error) => {
        console.error('Hiba az API hívás során: ', error);
      });
  };

  useEffect(() => {
    fetchAttractions(''); 
  }, []);

  const handleSearch = () => {
    console.log('Keresés:', search); 
    fetchAttractions(search); 
  };

  return (
    <View style={styles.container}>
      <Text>Attractions List:</Text>
      
      <TextInput
        style={styles.searchInput}
        placeholder="Search attractions"
        value={search}
        onChangeText={setSearch}
      />
      
      <Button title="Search" onPress={handleSearch} />
      
      <Text>{attractions.length ? '' : 'Nincs adat'}</Text>
      <FlatList
        data={attractions}
        keyExtractor={(item) => item.attractions_id.toString()}
        renderItem={({ item }) => (
          <View style={styles.item}>
            <Text style={styles.title}>{item.name}</Text>
            <Text>Város: {item.city_name}</Text>
            <Text>Leírás: {item.description}</Text>
            <Text>Típus: {item.type}</Text>
            <Text>Érdekeltség: {item.interest}</Text>
            <Text>Cím: {item.address}</Text>
            <Text>Készítette: {item.created_by}</Text>
            <Image source={{ uri: `${BASE_URL}/Turist_MobilApp/img/${item.image}` }}  
             style={styles.image}/>
          </View>
        )}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#fff',
    padding: 7,
  },
  searchInput: {
    width: '100%',
    height: 40,
    borderColor: '#ccc',
    borderWidth: 1,
    borderRadius: 5,
    marginBottom: 10,
    paddingLeft: 8,
  },
  item: {
    marginBottom: 15,
    padding: 10,
    borderWidth: 1,
    borderRadius: 5,
    borderColor: '#ddd',
    backgroundColor: '#c1ab86',
  },
  image: {
    width: 330,  
    height: 200, 
    resizeMode: 'contain', 
    margin: 10,
  },
  title: {
    fontSize: 20,        
    fontWeight: 'bold',   
    color: '#fff',        
    marginBottom: 10,     
    textAlign: 'center',  
  },
});

export default AttractionsScreen;
