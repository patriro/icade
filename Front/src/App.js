import React, { Component } from 'react';
import './App.css';
import GenreList from './components/GenreList';
import MovieList from './components/MovieList';
import Header from './components/Header';
import 'bootstrap/dist/css/bootstrap.min.css';

import { Row, Container, Col } from 'react-bootstrap';

class App extends Component {
    render() {
        return (
            <Container fluid>
                    <Header className="Header"/>
                    <Row>
                        <Col sm={4} className="GenreList">
                            <GenreList />
                        </Col>
                        <Col sm={8} className="MovieList">
                            <MovieList />
                        </Col>
                    </Row>
                </Container>
        )
    }
}

export default App