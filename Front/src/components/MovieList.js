import React, { Component } from 'react';
import axios from 'axios';
import { ListGroup, Card, Col, Row } from 'react-bootstrap'
import StarRatings from 'react-star-ratings';

export class MovieList extends Component {
    constructor(props) {
        super(props)

        this.state = {
            movies: [],
            errorMsg: ''
        }
    }

    componentDidMount() {
        axios
            .get('http://localhost:8080/api/movies')
            .then(response => {
                console.log(response)
                this.setState({ movies: response["data"]["hydra:member"] })
            })
            .catch(error => {
                console.log(error)
                this.setState({ errorMsg: 'Error retrieving data' })
            })
    }

    render() {
        const { movies, errorMsg } = this.state;
        return movies.map(movie => {
            return (
                <Card>
                    <Card.Header>
                        <Row>
                            <Col variant="left">
                                {movie.title} ({new Date(movie.releaseDate).getFullYear()})
                            </Col>
                            <Col className="text-right">
                                <StarRatings
                                    rating={Number(movie.voteAVG)/2}
                                    starRatedColor="yellow"
                                    numberOfStars={5}
                                    name='rating'
                                    starDimension="15px"
                                    starSpacing="1px"
                                /> <span className="voteCount">{movie.voteCount} votes</span>
                            </Col>
                        </Row>

                    </Card.Header>
                    <Card.Body>
                        <Row>
                            <Col variant="left" sm={2}>
                                <Card.Img src={movie.img} />
                            </Col>
                            <Col sm={10} variant="right">
                                {movie.overview}
                                <footer className="blockquote-footer">
                                    Titre original : <cite title="Source Title">{movie.originTitle}</cite>
                                </footer>
                            </Col>
                        </Row>
                    </Card.Body>
                </Card>
            )
        });
    }
}

export default MovieList