import React, {Component, useEffect, useState} from "react";
import {Route, Routes, Navigate, Link, withRouter, useParams, useLocation, generatePath} from 'react-router-dom';
import axios from "axios";

export default function Machine() {

    const [machineData, setData] = useState("");

    const params = useParams();

    const inputData = params.id;

    const getData = () => {
        axios.get('http://saitynai.ktu/api/machines/' + inputData).then(response =>
            setData(response.data)
        )}

    useEffect(() => {
        axios.get('http://saitynai.ktu/api/machines/' + inputData).then(response =>
            setData(response.data))
    })

    return (
        <div>
            <div className={"container"}>
                <div className={"col-lg-12"}>
                    <div className={"all-locations"}>
                        <ul>
                            <li style={{listStyle: 'none'}}>
                                <h4 style={{color: "white"}}>
                                    <span style={{color: '#007bff'}}>{machineData.name}</span> <br/>
                                    <span style={{color: '#007bff'}}>CPU:</span> {machineData.cpu}<br/>
                                    <span style={{color: '#007bff'}}>STORAGE:</span> {machineData.storage}<br/>
                                    <span style={{color: '#007bff'}}>RAM:</span> {machineData.ram}<br/>
                                    <span style={{color: '#007bff'}}>Location:</span> {machineData.location}<br/>
                                    <span style={{color: 'red'}}>${machineData.price}</span>/mo
                                </h4>
                            </li>
                        </ul>
                        <button class={"btn btn-danger"}>DELETE</button>
                    </div>
                </div>
            </div>
        </div>
    )
}