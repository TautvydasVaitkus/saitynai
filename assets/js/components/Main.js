import React, {Component} from 'react';
import {Link, Route, Routes, useParams} from "react-router-dom";
import Machines from "./Machines"
import Locations from "./Locations";
import Home from "./Home";
import Machine from "./Machine";
import AddMachine from './AddMachine'

class Main extends Component {
    render()
    {
        return(
            <div>
                <div>
                    <header className="site-navbar" role="banner">

                        <div className="container">
                            <div className="row align-items-center">

                                <div className="col-11 col-xl-2">
                                    <h1 className="mb-0 site-logo" style={{color: 'white'}}>Saitynai
                                    </h1>
                                </div>
                                <div className="col-12 col-md-10 d-none d-xl-block">
                                    <nav className="site-navigation position-relative text-right" role="navigation">

                                        <ul className="site-menu js-clone-nav mr-auto d-none d-lg-block">
                                            <li className="active"><Link className={"nav-link"} to={"/"}><span>Home</span></Link></li>
                                            <li><Link className={"nav-link"} to={"/machines"}><span>Machines</span></Link></li>
                                            <li><Link className={"nav-link"} to={"/locations"}><span>Locations</span></Link></li>
                                        </ul>
                                    </nav>
                                </div>


                                <div className="d-inline-block d-xl-none ml-md-0 mr-auto py-3"
                                     style={{position: 'relative', top: 3 + 'px'}}><a href="#"
                                                                                      className="site-menu-toggle js-menu-toggle text-white"><span
                                    className="icon-menu h3"></span></a></div>

                            </div>

                        </div>

                    </header>

                    <Routes>
                        <Route exact path="/machines" element={<Machines />}/>
                        <Route exact path="/locations" element={<Locations />}/>
                        <Route path="/machine/:id" element={<Machine />}/>
                        <Route exact path="/" element={<Home />}/>
                        <Route exact path="/add-machine" element={<AddMachine />} />
                    </Routes>
                </div>

                <div className="my-5">

                    <footer
                        className="text-center text-lg-start text-white"
                        style={{backgroundColor: '#1c2331'}}
                    >
                        <section
                            className="d-flex justify-content-between p-4"
                            style={{backgroundColor: '#6351ce'}}
                        >
                            <div className="me-5">
                                <span>Get connected with us on social networks:</span>
                            </div>

                            <div>
                                <a href="" className="text-white me-4">
                                    <i className="fab fa-facebook-f"></i>
                                </a>
                                <a href="" className="text-white me-4">
                                    <i className="fab fa-twitter"></i>
                                </a>
                                <a href="" className="text-white me-4">
                                    <i className="fab fa-google"></i>
                                </a>
                                <a href="" className="text-white me-4">
                                    <i className="fab fa-instagram"></i>
                                </a>
                                <a href="" className="text-white me-4">
                                    <i className="fab fa-linkedin"></i>
                                </a>
                                <a href="" className="text-white me-4">
                                    <i className="fab fa-github"></i>
                                </a>
                            </div>
                        </section>

                        <section className="">
                            <div className="container text-center text-md-start mt-5">
                                <div className="row mt-3">
                                    <div className="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                                        <h6 className="text-uppercase fw-bold">Company name</h6>
                                        <hr
                                            className="mb-4 mt-0 d-inline-block mx-auto"
                                            style={{width: 60 + 'px', backgroundColor: '#7c4dff', height: 2 + 'px'}}
                                        />
                                        <p>
                                            Here you can use rows and columns to organize your footer
                                            content. Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit.
                                        </p>
                                    </div>

                                    <div className="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                                        <h6 className="text-uppercase fw-bold">Products</h6>
                                        <hr
                                            className="mb-4 mt-0 d-inline-block mx-auto"
                                            style={{width: 60 + 'px', backgroundColor: '#7c4dff', height: 2 + 'px'}}
                                        />
                                        <p>
                                            <a href="#!" className="text-white">MDBootstrap</a>
                                        </p>
                                        <p>
                                            <a href="#!" className="text-white">MDWordPress</a>
                                        </p>
                                        <p>
                                            <a href="#!" className="text-white">BrandFlow</a>
                                        </p>
                                        <p>
                                            <a href="#!" className="text-white">Bootstrap Angular</a>
                                        </p>
                                    </div>

                                    <div className="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                                        <h6 className="text-uppercase fw-bold">Useful links</h6>
                                        <hr
                                            className="mb-4 mt-0 d-inline-block mx-auto"
                                            style={{width: 60 + 'px', backgroundColor: '#7c4dff', height: 2 + 'px'}}
                                        />
                                        <p>
                                            <a href="#!" className="text-white">Your Account</a>
                                        </p>
                                        <p>
                                            <a href="#!" className="text-white">Become an Affiliate</a>
                                        </p>
                                        <p>
                                            <a href="#!" className="text-white">Shipping Rates</a>
                                        </p>
                                        <p>
                                            <a href="#!" className="text-white">Help</a>
                                        </p>
                                    </div>

                                    <div className="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                                        <h6 className="text-uppercase fw-bold">Contact</h6>
                                        <hr
                                            className="mb-4 mt-0 d-inline-block mx-auto"
                                            style={{width: 60 + 'px', backgroundColor: '#7c4dff', height: 2 + 'px'}}
                                        />
                                        <p><i className="fas fa-home mr-3"></i> New York, NY 10012, US</p>
                                        <p><i className="fas fa-envelope mr-3"></i> info@example.com</p>
                                        <p><i className="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                                        <p><i className="fas fa-print mr-3"></i> + 01 234 567 89</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </footer>
                </div>
            </div>
        );
    }
}

export default Main;