# Xceed Backend Test - Documentation

## Introduction
This document outlines the steps taken to complete the Xceed Backend Test.

The approach to development will follow a progression from an initial simple solution to a more comprehensive and appropriate one through a series of refactorings.  
Each refactoring will be summarized in this documentation along with the corresponding commit or commits.

### Command list
- `composer test`: test de app
- `composer start`: start the app

### Todo list
- Return tweets uppercase
- Create cache layer
- ✅ Limit the count less than 10 (Value Object instead of int)
- Test

## Initial Implementation

Sets the foundation for future enhancements.

- [Implement basic tweet reader](https://github.com/marcduranxanco/tweet_reader_xceed/commit/ce1e057a6892a8ed98b33ceb0618a9156bcd51ff): Implemented basic functionality in `TweetConverterController` to return tweets in uppercase. The controller retrieves tweets from `TweetRepositoryInMemory`, converts them, and responds with a JSON array.

## Add TweetLimit value object and its test

- [Add the TweetLimit VO](https://github.com/marcduranxanco/tweet_reader_xceed/commit/f07d03b0047fe9834e7271daa740e0f37a7800d7): Instead of using int for the `searchByUserName` query, now `TweetLimit` value object is used for better control over that value
- [Test TweetLimit VO validating multiple cases](https://github.com/marcduranxanco/tweet_reader_xceed/commit/cde489a45240c3415f0a27ec60540131719dbaa8) 
- [Minor refactor after type testing](https://github.com/marcduranxanco/tweet_reader_xceed/commit/d7c41536643f1ff74270ef19959f7b797e8d629f)