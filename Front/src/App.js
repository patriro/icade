import React, { Component } from 'react';
import './App.css';
import GenreList from './components/GenreList';
import Header from './components/Header';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Row, Container, Col } from 'react-bootstrap';

class App extends Component {
    render() {
        return (
            <div className="App">
                <Container fluid className="Header">
                    <Row>
                        <Col>
                            <Header />
                        </Col>
                    </Row>
                    <Row>
                        <GenreList />
                    </Row>
                </Container>
            </div>
        )
    }
}
import { Form } from 'react-bootstrap';

export default App