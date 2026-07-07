while($row = $result->fetch_assoc()){
    echo $row['item_name'];
}