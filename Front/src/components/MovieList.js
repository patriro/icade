import React, { Component, useState } from 'react';
import axios from 'axios';
import { Card, Col, Row, Modal, ResponsiveEmbed, Image, Button } from 'react-bootstrap'
import StarRatings from 'react-star-ratings';

export class MovieList extends Component {
    constructor(props) {
        super(props);

        this.state = {
            nextPage: null,
            movies: [],
            movieSelected: false,
            modalIsOpen: false,
            errorMsg: '',
        }
    };

    componentDidMount() {
        axios
            .get('http://localhost:8080/api/movies')
            .then(response => {
                this.setState({ movies: response["data"]["hydra:member"] })
                this.setState({ nextPage: 2 })
            })
            .catch(error => {
                this.setState({ errorMsg: 'Error retrieving data' })
            })
    }

    displayMovieInfos(id) {

        if (this.state.movieSelected && id === this.state.movieSelected.id) {
            this.setState({ movieSelected: this.state.movieSelected });
            this.setState({ modalIsOpen: true });
            return;
        }

        axios
            .get('http://localhost:8080/api/movies/' + id)
            .then(response => {
                this.setState({ movieSelected: response["data"] });
                this.setState({ modalIsOpen: true });
            })
            .catch(error => {
                this.setState({ errorMsg: 'Error retrieving movie' })
            })
    };

    loadMoreMovies = () => {

        const nextPage = this.state.nextPage;
        axios
            .get('http://localhost:8080/api/movies/?page=' + nextPage)
            .then(response => {
                const newResponses = response["data"]["hydra:member"];
                const newArray = [...this.state.movies, ...newResponses];

                this.setState({ movies: newArray});
                this.setState({ nextPage: this.state.nextPage + 1 });
                return;
            })
            .catch(error => {
                this.setState({ errorMsg: 'Error retrieving movie' })
            })
    };

    closeModal = () => this.setState({ modalIsOpen: false });

    render() {
        const { movies, errorMsg, movieSelected } = this.state;

        return (
            <div>
                {movieSelected &&
                    <Modal show={this.state.modalIsOpen}
                        onHide={this.closeModal}
                        dialogClassName="modal-90w">
                    <Modal.Header>{movieSelected.title} ({new Date(movieSelected.releaseDate).getFullYear()})</Modal.Header>
                        <Modal.Body>
                        <div>
                            {movieSelected.keyVideo &&
                                <ResponsiveEmbed aspectRatio="16by9">
                                    <embed src={movieSelected.keyVideo} />
                                </ResponsiveEmbed>
                            }
                            {!movieSelected.keyVideo &&
                                <Image className="justify-content-center" src={movieSelected.img} rounded />
                            }
                        </div>
                        <div>
                            <p>Titre Original : {movieSelected.originTitle}</p>
                            <p>Description : <em>{movieSelected.overview}</em></p>
                            <p>Catégorie : <em>{movieSelected.genre.map(genre =>
                            <span key={genre.id}>
                                {genre.name + ' '}
                            </span>)}</em></p>
                        </div>
                        </Modal.Body>
                        <Modal.Footer>
                            <StarRatings
                                rating={Number(movieSelected.voteAVG) / 2}
                                starRatedColor="yellow"
                                numberOfStars={5}
                                name='rating'
                                starDimension="15px"
                                starSpacing="1px"
                            />
                            <span className="voteCount">{movieSelected.voteCount} votes</span>
                        </Modal.Footer>
                    </Modal>
                }
                {movies.map((movie, index) => (

                    <Card key={movie.id} onClick={(e) => {this.displayMovieInfos(movie.id)}}>
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
                ))}
                <div>
                    <Button variant="outline-primary" onClick={this.loadMoreMovies}>Load More Content</Button>
                </div>
            </div>
        );
    }
}

export default MovieList